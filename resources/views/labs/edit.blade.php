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

@include('layouts.partials.labs.header', ['title' => 'Edit'])

    
<div class="row">
                
    <div class="col-md-7">


        <div class="card">
            <div class="card-header">Update {{ $lab->name }}</div>

            <div class="card-body">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @foreach($errors->all() as $message)
                    <p>{{ $message }} </p>
                @endforeach
                
                

                <form action="{{ route('update_lab', $lab->slug) }}" method="POST" id="lab-form">
                    @csrf
                    {{ method_field('PUT') }}
                    @foreach($errors->all() as $message)
                        <p>{{ $message }} </p>
                    @endforeach
                    <div class="form-group">
                        <label for="lab-name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="lab-name" name="name" value="{{ $lab->name }}">
                    </div>
                    <div class="form-group">
                        <label for="lab-short-name" class="col-form-label">Short Name:</label>
                        <input type="text" class="form-control" id="lab-short-name" name="short_name" value="{{ $lab->short_name }}">
                    </div>
                    <div class="form-group">
                        <label for="lab-url" class="col-form-label">Url:</label>
                        <input type="text" class="form-control" id="lab-url" name="url" value="{{ $lab->url }}">
                    </div>

                `<button type="submit" class="btn btn-primary">Update {{ $lab->name }}</button>
                </form>

            </div>
        </div>
    </div>
    <div class="col-md-5">


        <div class="card">
            <div class="card-header">Update logo</div>

            <div class="card-body justify-content-center">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @foreach($errors->all() as $message)
                    <p>{{ $message }} </p>
                @endforeach
                
                <div class="row">
                    <div class="col text-center">
                        <img class="rounded-circle mb-4" src="{{ asset($lab->logo) }}" width="200px">
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col">
                        <form action="{{ route('update_lab_logo', $lab->slug) }}" method="POST" id="lab-form" class="text-left" enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT') }}
                            @foreach($errors->all() as $message)
                                <p>{{ $message }} </p>
                            @endforeach
                            
                            <div class="form-row justify-content-center">
                                <div class="form-group col-md-8">
                                    <input type="file" class="form-control" id="labLogo" lang="es" name='logo'>
                                </div>    

                                <div class="form-group col text-center">
                                    <button type="submit" class="btn btn-primary">Update logo </button>
                                </div>
                            </div>
    
                            
                            
                        </form>
                    </div>
                    
                </div>

                

            </div>
        </div>
    </div>
</div>


@endsection


@section('scripts')

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