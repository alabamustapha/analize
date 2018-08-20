@extends('layouts.admin')

@section('styles')

<style>
    #map{min-height: 400px;}
    .pac-container {
        z-index: 10000 !important;
    }
</style>
    
@endsection


@section('content')

@include('layouts.partials.labs.header', ['title' => 'Locations'])

    
<div class="row">
                
    <div class="col-md-8">

        <div class="modal bd-example-modal-lg fade" id="locationModal" role="dialog" aria-labelledby="locationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="locationModalLabel">Add {{ $lab->name }} Location</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <form action="{{ route('store_location', $lab->slug) }}" method="POST">
                                    @csrf
                                    <div class="form-row align-items-center">
                                    
                                    <div class="col-md-9">
                                        <label class="sr-only" for="locationAddressInput">Add Location</label>
                                        <input type="text" class="form-control mb-2" id="locationAddressInput" placeholder="add location" name="address" onFocus="geolocate()">
                                    </div>
                                    <input type="hidden" name="lab_id" value="{{ $lab->id }}">
                                    <input type="hidden" name="city" value="" id="location-city">
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary mb-2">Add location</button>
                                    </div>
                                    </div>
                                </form>
                                
                                <div id="map"></div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="card">
            <div class="card-header">Manage {{ $lab->name }} Locations</div>

            <div class="card-body">
                    <div class="row justify-content-center mb-3">
                        <div class="col-md-12">
                        <button type="button" class="btn btn-secondary float-right" data-toggle="modal" data-target="#locationModal">Add Location</button>
                        </div>
                    </div>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @foreach($errors->all() as $message)
                    <p>{{ $message }} </p>
                @endforeach
                

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Location</th>
                        <th scope="col">City</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lab->locations as $location)  
                    <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                        {{-- <td>{{ $location->name }}</td> --}}
                        <td>{{ $location->address }}</td>
                        <td>{{ $location->city or 'N/A' }}</td>
                        <td>
                            {{-- <a class="btn btn-secondary btn-sm" href="{{ route('edit_lab', ['lab' => $lab->id]) }}" target="_blank">Edit</a> --}}

                        <form class="delete_location" action="{{ route('delete_location', ['id' => $location->id ]) }}" method="POST" style="display: none;" id="location-{{ $location->id }}">
                                {{ method_field('DELETE') }}
                                @csrf
                            </form>
                            <button type="button" class="btn btn-secondary btn-sm delete_location" data-location-id="{{ $location->id }}">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>


@endsection


@section('scripts')

<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initAutocomplete" async defer></script>    

<script>
    function initAutocomplete() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -33.8688, lng: 151.2195},
        zoom: 13,
        mapTypeId: 'roadmap'
    });

    // Create the search box and link it to the UI element.
    var input = document.getElementById('locationAddressInput');
    var searchBox = new google.maps.places.SearchBox(input);
    // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });

    var markers = [];
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
        return;
        }

        // Clear out the old markers.
        markers.forEach(function(marker) {
        marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
        if (!place.geometry) {
            console.log("Returned place contains no geometry");
            return;
        }
        var icon = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
        };

        console.log(place);

        var locality = place.address_components.filter(function(address_component){
            return address_component.types.indexOf('locality') > -1 || address_component.types.indexOf('administrative_area_level_1') > -1
        });
        
        try {
            var city = locality[0].long_name;    
        } catch (error) {
            var city = 'N/A'; 
        }
        

        $('input#location-city').val(city);
        
        // Create a marker for each place.
        markers.push(new google.maps.Marker({
            map: map,
            icon: icon,
            title: place.name,
            position: place.geometry.location
        }));

        if (place.geometry.viewport) {
            // Only geocodes have viewport.
            bounds.union(place.geometry.viewport);
        } else {
            bounds.extend(place.geometry.location);
        }
        });
        map.fitBounds(bounds);
    });
    }
</script>

<script>

    $(document).ready(function(){
        $('.select2').select2();

        $('button.delete_lab').click(function(e){
            
            e.preventDefault();
            
            $("form.delete_lab").attr('action', $(this).data('url'))
            
            $("form.delete_lab").submit()
        });
    });

    $(document).ready(function(){
        $('#labModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var title = button.data('title') // Extract info from data-* attributes
            var submit_btn_text = button.data('submit-text') // Extract info from data-* attributes
            var url = button.data('url') // Extract info from data-* attributes
            var method = button.data('method') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text(title)
            modal.find('.modal-footer button#labModalSubmit').text(submit_btn_text)
            $("button#labModalSubmit").click(function(){
                document.getElementById('lab-form').submit();
            })
        })
    });       
    
    $(document).ready(function(){
        $('button.delete_location').click(function(){
            $('form#location-' + $(this).data('location-id')).submit();
        });
    });
</script>


@endsection