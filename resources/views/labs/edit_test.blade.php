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

@include('layouts.partials.labs.header', ['title' => 'Edit test'])

    
<div class="row">
                
    <div class="col-md-7">


        <div class="card">
            <div class="card-header">Update {{ $lab->name }} test</div>

            <div class="card-body">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @foreach($errors->all() as $message)
                    <p>{{ $message }} </p>
                @endforeach
                
                

                <form action="{{ route('update_test_group', ['lab' => $lab->slug, 'test' => $test->id]) }}" method="POST" id="lab-form">
                    @csrf
                    {{ method_field('PUT') }}
                    @foreach($errors->all() as $message)
                        <p>{{ $message }} </p>
                    @endforeach
                    
                    @if($test->is_scraped)
                    <div class="form-group">
                        <label for="test-scraped-name" class="col-form-label">Scraped name:</label>
                        <input type="text" name="scraped_name" id="test-scraped-name" class="form-control" value="{{ $test->scraped_name }}" disabled>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="test-name" class="col-form-label">Test name:</label>
                        <input type="text" name="name" id="test-name" class="form-control" value="{{ $test->name }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="test-price" class="col-form-label">Test price:</label>
                        <input type="number" name="price" id="test-price" class="form-control" value="{{ $test->price }}" {{ $test->is_scraped ? 'disabled' : '' }}>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update test</button>
                </form>

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