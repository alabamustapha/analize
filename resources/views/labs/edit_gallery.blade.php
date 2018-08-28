@extends('layouts.admin')

@section('styles')

    
@endsection


@section('content')

@include('layouts.partials.labs.header', ['title' => 'Images'])


<div class="row">
                
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">{{ $lab->name }}: Edit Image gallery</div>

            <div class="card-body">

               

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                
                <form action="{{ route('update_gallery_image', ['lab' => $lab->slug, 'image' => $image]) }}" method="POST" id="lab-images" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        @foreach($errors->all() as $message)
                            <p>{{ $message }} </p>
                        @endforeach
                    
                        <input type="hidden" name="lab_id" value="{{ $lab->id }}">
                        
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name='title' value="{{ $image->title}}">
                        </div>       
                        
                        <div class="form-group">
                            <label for="gallery_image">Image:</label>
                            <input type="file" class="form-control" id="gallery_image" name='gallery_image'>
                            <div class="mt-3">
                                <img class="image-responsive" src="{{ asset($image->url) }}" alt="{{ $image->title}}" width="50">
                            </div>
                        </div>    
                        
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="6">{{ $image->description }}</textarea>
                        </div>    
    
                        
                        <div class="form-group">
                            <label for="rank">Rank:</label>
                            <input type="text" class="form-control" id="rank" name='rank' value="{{ $image->rank}}">
                        </div> 
    
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update </button>
                        </div>
                        
                    </form>
                
            </div>
        </div>
    </div>
   
</div>


@endsection


@section('scripts')

<script>
    
        $('button.delete_image').click(function(e){
                    
                    e.preventDefault();
                
                    $("form.delete_image").attr('action', $(this).data('url')).submit();
                    
                    
                });
                
        </script>


@endsection