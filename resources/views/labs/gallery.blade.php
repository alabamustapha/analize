@extends('layouts.admin')

@section('styles')

    
@endsection


@section('content')

@include('layouts.partials.labs.header', ['title' => 'Images'])



<div class="modal fade" id="labGalleryModal" role="dialog" aria-labelledby="labGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labGalleryModalLabel">Add image to gallery</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add_gallery_image', $lab->slug) }}" method="POST" id="lab-images" enctype="multipart/form-data">
                    @csrf
                    
                    @foreach($errors->all() as $message)
                        <p>{{ $message }} </p>
                    @endforeach
                
                    <input type="hidden" name="lab_id" value="{{ $lab->id }}">
                    
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name='title'>
                    </div>       
                    
                    <div class="form-group">
                        <label for="gallery_image">Image:</label>
                        <input type="file" class="form-control" id="gallery_image" name='gallery_image'>
                    </div>    
                    
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="6"></textarea>
                    </div>    

                    
                    <div class="form-group">
                        <label for="rank">Rank:</label>
                        <input type="text" class="form-control" id="rank" name='rank'>
                    </div> 

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Continue </button>
                    </div>
                    
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
                
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">{{ $lab->name }}: Image gallery</div>

            <div class="card-body">

                <div class="row justify-content-center mb-3">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-secondary float-right" data-toggle="modal" data-target="#labGalleryModal">Add Image</button>
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
                
                <table class="table ">
                    <thead>
                        <th>Title</th>
                        <th>Img</th>
                        <th>Description</th>
                        <th>Rank</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($lab->images as $image)
                            <tr>
                                <td>{{ $image->title }}</td>
                                <td>{{ $image->img }}</td>
                                <td>{{ $image->description }}</td>
                                <td>{{ $image->rank }}</td>
                                <td>
                                    edit/delete
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



@endsection