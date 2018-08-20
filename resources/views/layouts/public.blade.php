<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Analize') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css"> --}}
    <link rel="stylesheet" id="google-fonts-style-css" href="https://fonts.googleapis.com/css?family=Raleway%3A400%2C700%7COpen+Sans%3A300italic%2C400%2C400italic%2C600%2C600italic%2C700%7CRoboto%3A300%2C400%2C400italic%2C500%2C500italic%2C700%2C900&amp;ver=8.8.2" type="text/css" media="all">

    <!-- Styles -->
    
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/site.css') }}" rel="stylesheet">
    
    
    @yield('styles')
</head>
<body class="bg-white">

    
    <div class="modal fade" id="userLocation" role="dialog" aria-labelledby="userLocationLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="userLocationLabel">{{ __('general.Enter address to get closest Lab') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label class="sr-only" for="locationAddressInput">{{ __('general.Cities') }}</label>
                <select name="city" id="city" class="form-control mb-2 select2" style="width: 100%; min-height: 40px;">
                    <option value="">select city</option>
                    @foreach($cities as $city)
                        <option value="{{$city}}">{{ $city }}</option>
                    @endforeach    
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.Close') }}</button>
                <button type="button" class="btn btn-primary" id="userLocation">{{ __('general.Continue') }}</button>
            </div>
            </div>
        </div>
    </div>
{{--     
    <div class="modal fade" id="userLocation" role="dialog" aria-labelledby="userLocationLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="userLocationLabel">{{ __('general.Enter address to get closest Lab') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <label class="sr-only" for="locationAddressInput">{{ __('general.Add location') }}</label>
                    <input type="text" class="form-control mb-2" id="locationAddressInput" placeholder="{{ __('general.Add location') }}" name="address">
                    <input type="text" class="form-control mb-2" id="locationAddressCity" placeholder="Location city" name="city">
                    <div id="map"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.Close') }}</button>
                <button type="button" class="btn btn-primary" id="userLocation">{{ __('general.Continue') }}</button>
            </div>
            </div>
        </div>
    </div> 
--}}

    <div id="app">
         
        <nav class="navbar navbar-expand-md navbar-light bg-white navbar-be-healthy">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('img/logo.png') }}" width="80" alt="{{ config('app.name', 'Analize') }}">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                   
                    <ul class="navbar-nav mr-auto ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="http://be-healthy.ro/" target="_blank">{{ __('Acasă') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">{{ __('Analize') }}</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('labs') }}">{{ __('Laboratoare') }}</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                       
                        <li class="nav-item dropdown" id="cart-dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="{{ route('show_cart') }}"><i class="fa fa-shopping-cart"></i>&nbsp;{{ __('Coș') }} (<span class="badge badge-light" id="cart-count">{{ session()->has('cart_items') ? count(session()->get('cart_items')) : 0 }}</span>)</a>
                            
                            <div class="dropdown-menu">
                                

                                    <div id="cart-groupings">
                                        @if( session()->get('cart_groups') && session()->get('cart_groups')->count() > 0 )
                                            @foreach(session()->get('cart_groups') as $group)
                                                <div class="dropdown-item" id="cart-item-{{ $group->id}}">
                                                    <div class="cart-item d-flex justify-content-between">
                                                        <span class="cart-item-name text-left" href="#">{{ $group->name }}</span>
                                                        <a class="remove-item text-right text-danger" data-id="{{ $group->id }}"><i class="fa fa-times"></i></a>
                                                    </div>
                                                </div> 
                                            @endforeach
                                        @endif    
                                    </div>


                                @if( session()->get('cart_groups') && session()->get('cart_groups')->count() > 0 )
                                <button type="button" class="btn btn-secondary userLocation" data-toggle="modal" data-target="#userLocation">{{ __('general.Checkout') }}</button>        
                                
                                @else
                                <a class="dropdown-item" href="#" id="cart-empty">{{ __('general.Cart empty') }}</a>    
                                @endif
                                
                            </div>
                        </li>
                        
                        @guest
                            
                        @else
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('category_index') }}">{{ __('Manage Categories') }}</a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('group_index') }}">{{ __('Manage Group') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="https://use.fontawesome.com/ac418ff0a5.js"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initAutocomplete" async defer></script>
    
    <script>
        $.ajaxPrefilter(function(options, originalOptions, xhr) { 
        var token = $('meta[name="csrf-token"]').attr('content'); 
        if (token) {
            return xhr.setRequestHeader('X-CSRF-TOKEN', token); 
        }
    });

    $(document).ready(function(){

        $('.select2').select2();
        
        $('button#userLocation').click(function(e){
            e.preventDefault();
            
            $("input[name='city']").val($("select#city").val());

            $('form#cart-form').submit();
        });
    });

    $(document).ready(function(){

        $('li#cart-dropdown, li#cart-dropdown .dropdown-menu').mouseover(function(e){
            $('li#cart-dropdown').addClass('show');
            $('li#cart-dropdown .dropdown-menu').addClass('show');
        })
        
        
    });

  
  $(document).ready(function(){
        
        $('ul.groups-lists li.list-group-item button.add_to_cart').click(function(){
            var group_id = $(this).data('id');
             $.ajax({
                 type: "POST",
                 url: window.location.origin + '/cart/add',
                 data: {group_id: group_id},
                 success: function( response ) {
                 
 
                     if(Object.keys(response.cart_items).length >= 1){
                         
                         response.cart_groups.forEach(function(group){
                             
                             if($('li#cart-dropdown').find('.dropdown-menu #cart-groupings').children('div#cart-item-' + group.id).length == 0){
 
                                 var item = "<div class='dropdown-item' id='cart-item-" + group.id + "'><div class='cart-item d-flex justify-content-between'><span class='cart-item-name text-left'>" + group.name + "</span><a class='remove-item text-right text-danger' data-id='" + group.id + "'><i class='fa fa-times'></i></a></div></div>";
 
                                 $('li#cart-dropdown').find('div#cart-groupings').append(item);
                                 
                                 $('div#cart-item-' + group.id + ' a.remove-item').click(function(e){
                                     
                                         e.preventDefault();
                                         removeItem(group.id);
 
                                 });
 
                             }
                         });
                         
                     }else{
 
                         response.cart_groups.forEach(function(group){
                             
                             if($('li#cart-dropdown').find('.dropdown-menu #cart-groupings').children('div#cart-item-' + group.id).length == 0){
 
                                 var item = "<div class='dropdown-item' id='cart-item-" + group.id + "'><div class='cart-item d-flex justify-content-between'>" + "<span class='cart-item-name text-left'>" + group.name + "</span><a class='remove-item text-right text-danger' data-id='" + group.id + "'><i class='fa fa-times'></i></a></div></div>";
 
                                 $('li#cart-dropdown').find('div#cart-groupings').append(item);
                                 
                                 $('div#cart-item-' + group.id + ' a.remove-item').click(function(e){
                                     
                                     e.preventDefault();
                                     
                                     var group_id = group.id ;
                                         
                                     removeItem(group_id)
 
                                 });
 
                             }
                         });
 
                        
                     }

                        var checkout = '<button type="button" class="btn btn-secondary userLocation" data-toggle="modal" data-target="#userLocation">{{ __('general.Checkout') }}</button>'
                         
                         if($('button.userLocation[data-target="#userLocation"]').length == 0){
                            $('li#cart-dropdown .dropdown-menu').append(checkout);
                         }
                         
                         // <a class="dropdown-item" href="#" id="cart-empty">Cart empty</a>
                         $('a#cart-empty').remove();
                     
                     $('span#cart-count').text(Object.keys(response.cart_items).length)
 
                 }
             });
        });
 
     });
     
 
     $(document).ready(function(){
         $('.cart-item a.remove-item').click(function(e){
             e.preventDefault();
             var group_id = $(this).data('id');
             removeItem(group_id);
        });
     });
 
 
     function removeItem(group_id) {
         
         $.ajax({
             type: "POST",
             url: window.location.origin + '/cart/remove',
             data: {group_id: group_id},
             success: function( response ) {
                 
                 $('span#cart-count').text(Object.keys(response.cart_items).length)
                 
                 $("div#cart-item-" + group_id).remove()
 
                 if(response.cart_items.length == 0){
                     $("button.userLocation").remove();
                     $("li#cart-dropdown .dropdown-menu").append('<a class="dropdown-item" href="#" id="cart-empty">{{ __("general.Cart empty") }}</a>')
                 }
 
             },
             error: function(xhr,status,error){
                 console.log(error)
             }
             
         });
     }

    
    </script>
    @yield('scripts')
</body>
</html>
