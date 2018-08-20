@extends('layouts.admin')

@section('content')

<h1 class="h2 mt-3">Manage Categories</h1>

<div class="row">
    <div class="col-md-8">

        <div class="modal fade" id="categoryModal" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="categoryModalLabel">Create new category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('store_category') }}" method="POST" id="category-form">
                            @csrf
                            @foreach($errors->all() as $message)
                                <p>{{ $message }} </p>
                            @endforeach
                            <div class="form-group">
                                <label for="category-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="category-name" name="name" value="{{ old('name') }}">
                            </div>

                        </form>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="categoryModalSubmit">Create</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Add/Edit/Delete</div>

            <div class="card-body">

                    <div class="row justify-content-center mb-3">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-right" data-toggle="modal" data-target="#categoryModal" data-title="Add new category" data-submit-text="Create category" data-url="category/create" data-method="POST">New Category</button>
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
                        <th scope="col">Groups</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)  
                        <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->groups->count() }}</td>
                        <td>
                        
                            <a class="btn btn-secondary btn-sm" href="{{ route('edit_category', ['category' => $category->id]) }}" target="_blank">Edit</a>

                            <form class="delete_category" action="" method="POST" style="display: none;">
                                {{ method_field('DELETE') }}
                                @csrf
                            </form>
                            <button type="button" class="btn btn-secondary btn-sm delete_category"  data-title="Delete catagory" data-submit-text="Delete" data-url="categories/{{$category->id}}">Delete</button>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                    <div class="float-right">
                        {{ $categories->links() }}
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

        $('button.delete_category').click(function(e){
            
            e.preventDefault();
            
            $("form.delete_category").attr('action', $(this).data('url'))
            
            $("form.delete_category").submit()
        });
    });

    $(document).ready(function(){
        $('#categoryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var title = button.data('title') // Extract info from data-* attributes
            var submit_btn_text = button.data('submit-text') // Extract info from data-* attributes
            var url = button.data('url') // Extract info from data-* attributes
            var method = button.data('method') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text(title)
            modal.find('.modal-footer button#categoryModalSubmit').text(submit_btn_text)
            $("button#categoryModalSubmit").click(function(){
                document.getElementById('category-form').submit();
            })
        })
    });        
</script>

@endsection