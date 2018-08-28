@extends('layouts.public')


@section('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css" />
    
@endsection

@section('content')

<section class="jumbotron text-center mb-0">
    <div class="container">
    <img src="{{ $lab->logo ? asset($lab->logo): asset('img/lab-bio.jpg') }}" alt="{{ $lab->name . ' logo' }}" class="rounded-circle" width="100">
        <h2 class="jumbotron-heading">{{ $lab->name }}</h2>
        <p class="lead text-muted">
            {{ str_finish($lab->bio_excerpt, '...') }}
        </p>
        <p>
        <a href="#teams" class="btn btn-primary my-2">View team</a>
        <a href="#gallery" class="btn btn-secondary my-2">Gallery</a>
        <a href="#packages" class="btn btn-secondary my-2">Packages</a>
        </p>
    </div>
</section>

<div class="container-fluid pr-0 pl-0">
    <div class="row" style="max-height: 330px;">
        <div class="col-md-4 mr-0 pr-0">
            <img class="" src="{{ $lab->bio_image ? asset($lab->bio_image): asset('img/lab-bio.jpg') }}" alt="" srcset="" width="100%" style="display: inline-block; height: 330px;">
        </div>
        <div class="col-md-8 pl-0" style="backgroud-color:#20a1d9;">

            <section style="min-height: 330px; max-height: 330px; overflow-y: scroll;">    
                <div class="container">
                    <h2 class="text-info align-left">About Synlab</h2>
                    <p class="lead text-muted bio">
                        {{ $lab->bio }}
                    </p>
                </div>
            </section>
                
        </div>
    </div>
</div>


<div class="teams py-5 bg-light" id="teams">
    <div class="container">

        
        <div class="team-head px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            
                <div class="heading">
                    <h2 class="team-title">Synlab Teams</h2>
                    <p class="lead">Some of our qualify experts</p>
                </div>
            
        </div>
        <div class="row">
            @foreach($teams as $team)
            <div class="col-md-3 text-center">
                <img class="rounded-circle" src="{{ asset($team->avatar) }}" width="200" height="200">
                <div class="mb-4">
                    <h3>{{ $team->name }}</h3>
                    <span>{{ $team->title }}</span>
                </div>
            </div>
           @endforeach
        </div>
    </div>
</div>


<section class="gallery-block compact-gallery" id="gallery">
    <div class="container">
        <div class="heading">
             <h2>{{ $lab->name }} Gallery</h2>
        </div>
        <div class="row no-gutters">
            @foreach($lab->images as $image)
            <div class="col-md-6 col-lg-4 item zoom-on-hover">
                <a class="lightbox" href="{{ asset($image->url) }}">
                    <img class="img-fluid image lab-image" src="{{ asset($image->url) }}">
                    <span class="description">
                        <span class="description-heading">{{ $image->title }}</span>
                        <span class="description-body">{{ $image->description }}</span>
                    </span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>


<section id="packages">
        
        <div class="contest_timeline_main">
            
            <h2>{{ $lab->name }} Packages</h2>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Package</th>
                        <th scope="col">Tests</th>
                        <th scope="col">Price</th>
                    </tr>
                    </thead>
                    <tbody>
                            @foreach($lab->packages as $package)
                            <tr>
                                <td>{{ $package->name }}</td>
                                <td>
                                    @foreach($package->groups as $group)
                                        @if(!$loop->last)
                                            {{ $group->name . ', '}}
                                        @else    
                                        {{ $group->name }}
                                        @endif    
                                    @endforeach
                                </td>
                                <td>{{ $package->price }}</td>
                                
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    
</section>


@endsection

@section('scripts')


<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>

<script>
    baguetteBox.run('.compact-gallery', { animation: 'slideIn'});
</script>

@endsection