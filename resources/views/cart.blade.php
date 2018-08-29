@extends('layouts.public')

@section('styles')

<style>
    #map{min-height: 400px;}
    .pac-container {
        z-index: 10000 !important;
    }
</style>
    
@endsection


@section('content')


<div class="modal bd-example-modal-lg fade" id="locationModal" role="dialog" aria-labelledby="locationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-9">
                            <label class="sr-only" for="locationAddressInput">Add Location</label>
                            <input type="text" class="form-control mb-2" id="locationAddressInput" placeholder="add location" name="address">
                        </div>
                            
                        <div class="col-md-3">
                            <button class="btn btn-success btn-border" id="btnClosestLocation">continue</button>
                        </div>
                    </div>    

                    <table class="table table-hover table-striped" id="rankedLocation">
                        <tbody>
                            
                        </tbody>
                    </table>
                
                    {{-- <div id="map"></div> --}}
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="container pl-5 pr-5">
        
  
<div class="row">
    
    <div class="col-md-12">
        <h4 class="mb-3">Teste analize</h4>
        
            @if($labs->count() > 0)
                @foreach($labs as $lab)
                
                    @if($lab->tests->count() > 0)
                        <h4 class="mb-3">{{ $lab->name }} </h4>
                        
                        <div class="card card-body mb-3">

                            <div class="row d-flex justify-content-between">
                                <div class="col-md-3 text-center">
                                    <img src="{{ asset('img/logo.png') }}" alt="" width="50">
                                    <h4 class="mt-2">{{ $lab->name }}</h4>
                                </div>
                                <div class="col-md-5 text-center">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>{{ __('general.Nr. of tests') }}</h4>
                                            {{ $lab->tests->count() }}                    
                                        </div>
                                        <div class="col-md-6">
                                            <h4>{{ __('general.Total price') }}</h4>
                                            {{ number_format($lab->tests->sum('price'), 2, '.', ',') }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            
                                            @if($lab->locations && $lab->locations->count() > 0)
                                                    @if($lab->locations->count() == 1)
                                                    
                                                    <span>{{ $lab->locations->first()->address }}</span>
                                                    
                                                    <a href="{{ linkToMap($lab->locations->first()->address) }}" class="btn btn-primary btn-block view-on-map" target="_blank">{{ __('general.View on map') }}</a>
                                                    
                                                    @else
                                                        <span>{{ optional($lab->locations)->count() . ' '.__('general.Locations available') }} in {{ count(array_unique($lab->locations->pluck('city')->toArray())) }} cities</span>
                                                            
                                                            @foreach($lab->locations as $location)
                                                                <input class="locations-{{$lab->id}}" type="hidden" value="{{ $location->address }}">       
                                                            @endforeach
                                                            
                                                            <button class="btn btn-primary btn-block nearest-location" data-slug="{{$lab->slug}}" data-city="{{ $city }}">{{ $lab->locations->count() ? __('general.Get nearest location') : __('general.No location') }}</button>    
                                                    @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                                                        
                        </div>
                    @endif
                @endforeach
            @else
            
            <h3 class="text-info"> {{ __('general.No item') }} <a href="{{ route('home') }}"> {{ __('general.Add item') }}</a></h3>
            
            @endif
        
            <table class="table table-striped table-hover table-bordered" id="cart-summary">
                <thead>
                    <tr>
                        <th></th>
                        @foreach($labs as $lab)
                            <th>{{ $lab->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($groups as $group)
                    <tr>
                        <td>
                            {{ $group->name }}
                        </td>
                        
                            @foreach($labs as $lab)
                            <td>
                                @foreach($lab->tests->where('group_id', $group->id) as $test)
                                    
                                    {{ $test->name . '(' . $test->price . ')' }}
                                    @if($loop->iteration > 1 && !$loop->last)
                                    {{ ', ' }}
                                    @endif
                                @endforeach
                            </td>    
                            @endforeach 
                        
                        {{-- @foreach($lab->tests as $test)
                            <td>{{ $test->price }}</td>
                        @endforeach --}}
                    </tr>
                    @endforeach
                    <tr>
                        <td>Total</td>
                        @foreach($labs as $lab)
                            <td>{{ number_format($lab->tests->sum('price'), 2, '.', ',') }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        
    </div>
</div>
  
</div>
  
      
@endsection


@section('scripts')
{{-- <script src="https://cdn.mapfit.com/v2-4/assets/js/mapfit.js"></script> --}}
<script>
        function initAutocomplete() {
    
        // Create the search box and link it to the UI element.
        var input = document.getElementById('locationAddressInput');
        var searchBox = new google.maps.places.SearchBox(input);

        
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
    
            var places = searchBox.getPlaces();
     
                if (places.length == 0) {
                    return;
                }
                console.log(place);
                
            });
        }
    </script>
<script>

    $(document).ready(function(){

        let city = '';
        let lab_slug = '';

        $('.nearest-location').click(function(){
            $('#locationModal').modal('show');

            city = $(this).data('city');    
            lab_slug = $(this).data('slug');    
        });

        
        $("#btnClosestLocation").click(function(e){

            let userLocation = $('#locationAddressInput').val();
            $("table#rankedLocation tbody").empty();
            

            if(userLocation != ''){
                $.ajax({
                    type: "POST",
                    url:  "{{ route('closest_location') }}",
                    data:  {city: city, lab_slug: lab_slug, address: userLocation},
                    success: function( response ) {
                        $("table#rankedLocation tbody").empty();
                            response.forEach(location => {
                                console.log(location)
                                $("table#rankedLocation tbody").append(
                                    `<tr>
                                        <td>` + location.location + `(` + location.distance_text + `)` + `<td>
                                        <td><a href='https://maps.google.com/maps?q=` + encodeURI(location.location) + `'>view</a></td>
                                    </tr>`
                                )
                            });
                            // console.log(response);

                    },
                    error: function(xhr,status,error){
                        console.log(status)
                        console.log(error)
                    }
                    
                });
            }
            

        });
    });

</script>


<!-- mapfit code implementation -->
{{-- <script> 

   $(document).ready(function(){

       $('.nearest-location').click(function(){
        
            let location_distance = [];
        
            mapfit.apikey = "591dccc4e499ca0001a4c6a440ee9820872d4a749cbebc5ff8879f9b";
            
            let key = "591dccc4e499ca0001a4c6a440ee9820872d4a749cbebc5ff8879f9b";
            
            
        
            let geo = new mapfit.Geocoder(key, "https://api.mapfit.com/v2");

            let directionsReq = new mapfit.Directions(key, "https://api.mapfit.com/v2");
            
            var locations = $('.locations-' + $(this).data('labId'));    
            console.log(locations)
            $("#btnClosestLocation").click(function(e){

            e.preventDefault();

            let userLocation = $('#locationAddressInput').val();

            
            locations.each(function(){
                var location = $(this);
                
                console.log(location.val());

                directionsReq.route('Goni Gora, Kaduna, Nigeria', location.val(), 'driving')
                 .then(function(data) {
                     console.log(data);
                    //  console.log(data.trip.summary.length);
                  });


                location_distance.push([location.val(), 200]);

                
            });    
                
            })
             
    
                  
        
        
            });
   });
</script> --}}

@endsection