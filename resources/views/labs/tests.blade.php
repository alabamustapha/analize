@extends('layouts.admin')

@section('content')

@include('layouts.partials.labs.header', ['title' => 'Dashboard'])

<div class="row">
    <div class="col-md-8">

        <div class="modal fade" id="labModal" role="dialog" aria-labelledby="labModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="labModalLabel">Create new Lab</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('store_lab') }}" method="POST" id="lab-form">
                            @csrf
                            @foreach($errors->all() as $message)
                                <p>{{ $message }} </p>
                            @endforeach
                            <div class="form-group">
                                <label for="lab-name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" id="lab-name" name="name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="lab-short-name" class="col-form-label">Short Name:</label>
                                <input type="text" class="form-control" id="lab-short-name" name="short_name" value="{{ old('short_name') }}">
                            </div>
                            <div class="form-group">
                                <label for="lab-url" class="col-form-label">Url:</label>
                                <input type="text" class="form-control" id="lab-url" name="url" value="{{ old('url') }}">
                            </div>

                        </form>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="labModalSubmit">Create</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
        <div class="card-header">Manage {{ $lab->name}} Tests</div>

            <div class="card-body">

                    <div class="row justify-content-center mb-3">
                        <div class="col-md-12">
                                <div class="btn-group float-right" role="group" aria-label="manage lab">
                                        <form class="scrape_lab_tests" action="{{ route('scrape_lab_tests', ['slug' => $lab->slug]) }}" method="POST" style="display: none;" id="scrape_lab_tests">
                                            @csrf
                                        </form>

                                        <button type="button" class="btn btn-primary" 
                                        onclick="event.preventDefault();
                                        document.getElementById('scrape_lab_tests').submit();">Scrape tests</button>
                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#labModal" data-title="Add new Lab" data-submit-text="Create lab" data-url="category/create" data-method="POST">Add Test</button>
                                </div>
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
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tests as $test)  
                        <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $test->name }}</td>
                        <td>{{ $test->price }}</td>
                        <td>
                            <a class="btn btn-secondary btn-sm" href="{{ route('show_lab', ['lab' => $lab->slug]) }}" target="_blank">View</a>
                            <a class="btn btn-secondary btn-sm" href="{{ route('edit_lab', ['lab' => $lab->id]) }}" target="_blank">Edit</a>

                            <form class="delete_lab_test" action="{{ route('delete_lab_test', ['lab' => $lab->slug, 'test' => $test->id ]) }}" method="POST" style="display: none;">
                            @csrf    
                            {{ method_field('DELETE') }}
                                
                            </form>
                            <button type="button" class="btn btn-secondary btn-sm delete_lab_test">Delete</button>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                    <div class="float-right">
                    {{ $tests->links() }}
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

        $('button.delete_lab_test').click(function(e){
            
            e.preventDefault();
            
            // $("form.delete_lab_test").attr('action', $(this).data('url'))
            
            $(this).siblings('form.delete_lab_test').submit()
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
</script>

@endsection