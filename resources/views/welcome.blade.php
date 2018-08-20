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


<div class="container bg-white healthy-container">
        
    <div class="row">
          
        <div class="col-md-3 mb-4">

                <h4 class="mb-3 healthy-title">
                    <span class="title">  {{ __('general.Categories') }} </span>
                {{-- <span class="badge badge-secondary badge-pill">{{ $categories->count() }}</span> --}}
                </h4>
                <ul class="list-group mb-3">      
                    <li class="list-group-item d-flex justify-content-between">
                    <a data-id="0" href="{{ route('home', ['category' => 0]) }}"> {{ __('general.All') }}</a>
                        {{-- <strong>{{ $groups->count() }}</strong> --}}
                    </li>
                    @foreach($categories as $category)
                    <li class="list-group-item d-flex justify-content-between">
                    <a data-id="{{ $category->id }}" href="{{ route('home', ['category' => $category->id]) }}">{{ $category->name }}</a>
                        {{-- <strong>{{ $category->groups()->count() }}</strong> --}}
                    </li>
                    @endforeach
                </ul>

                <h4 class="mb-3 healthy-title">
                        <span class="title">{{ __('general.Laboratories') }}</span>
                        {{-- <span class="badge badge-secondary badge-pill">{{ $categories->count() }}</span> --}}
                    </h4>
                    <ul class="list-group mb-3">
                    <form method="POST" action="{{ route('show_cart') }}" id='cart-form'>      
                            @csrf
                            @foreach($laboratories as $lab)
                            <li class="list-group-item">
                            <input type="checkbox" name='labs[]' value="{{ $lab->id }}" checked>&nbsp;<span>{{ $lab->name }}</span>
                                {{-- <strong>{{ $category->groups()->count() }}</strong> --}}
                            </li>
                            @endforeach
                            <input type="hidden" name="city" value="">
                        </form>
                    </ul>
              
        </div>

        <div class="col-md-9">
                
            <h4 class="mb-3 healthy-title">
                <span class="title">Teste de sânge</span>
            </h4>
                  
            <div class="card card-body">  
                <div class="row mb-3">
                    <div class="col-md-6 align-self-center">
                        <h4>Cauta un test dupa nume sau cod:</h4>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control form-control-lg" type="text" placeholder="{{ __('general.Search test') }}" id="search-group">
                    </div>
                </div>
                <div class="letter-menu">
                    <ul class="nav justify-content-center mb-2">
                        @foreach($letters as $letter)
                        <li class="nav-item">
                            <a class="nav-link p-0" href="#{{ $letter }}">{{ $letter }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
        
                @foreach($groups as $grouped)
                    
                        <span id="{{ $letters[$loop->index] }}"></span>   
                    {{-- <div class="row d-flex justify-content-between list-title"id="{{ $letters[$loop->index] }}">

                        <strong> {{ $letters[$loop->index] }} </strong>
                    
                        <button class="btn btn-primary btn-close btn-collapse align-middle" type="button" data-target="#list-{{ $letters[$loop->index] }}" aria-expanded="false" aria-controls="#list-{{ $letters[$loop->index] }}">
                                <i class="fa fa-arrow-up" aria-hidden="true"></i>
                        </button>
                    </div> --}}
                    
                    
                    <div class="collapse" id="list-{{ $letters[$loop->index] }}">
                        <ul class="list-group list-group-flush groups-lists mt-1 mb-1">
                            @foreach($grouped as $group)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="group-name">{{ $group->name }}</span>
                                    
                                    <div>
                                            <a href="{{ $group->url or '#' }}" title="{{ $group->url }}" target="_blank"> Detalii analiză</a>
                                            {{-- <button class="btn btn-primary"> Add to cart</button> --}}
                                            <button class="btn btn-primary add_to_cart d-none" type="button" data-id="{{ $group->id }}">
                                                    {{ __('general.Add item') }} <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                    </div>
                                    
                                </li>
                            @endforeach
                        </ul>   
                    </div>
                @endforeach
                          
            </div>
            
               
        </div>
    </div>
  
</div>


      
@endsection
    
@section('scripts')
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
        

        $('input#locationAddressCity').val(city);
        
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

    
$(document).ready(function(){

    $("input#search-group").keyup(function(){
        
        _this = this;
        
        $.each($(".groups-lists").find("li"), function() {
            // console.log($(this).find('span.group-name').text());
            group = this;

            if($(this).find('span.group-name').text().toLowerCase().indexOf($(_this).val().toLowerCase()) == -1)
                $(group).hide().removeClass('d-flex');
            else
                $(group).show().addClass('d-flex');
                
        });
    
    })
    
});

$(document).ready(function(){
    
    $('.collapse').collapse();

    $("button.btn-collapse").click(function(e){
        e.preventDefault();
        
        if($(this).find('i').first().hasClass('fa-arrow-up')){
            $(this).find('i').first().removeClass('fa-arrow-up').addClass('fa-arrow-down');
        }else if($(this).find('i').first().hasClass('fa-arrow-down')){
            $(this).find('i').first().removeClass('fa-arrow-down').addClass('fa-arrow-up');
        }
        
        $('div' + $(this).data('target')).collapse('toggle');
    });
});

$(document).ready(function(){
    
    $('ul.groups-lists li.list-group-item').mouseover(function(){
        $(this).find('button.add_to_cart').removeClass('d-none');
    });
    
    $('ul.groups-lists li.list-group-item').mouseleave(function(){
        $(this).find('button.add_to_cart').addClass('d-none');
    });

});

 
</script>


@endsection