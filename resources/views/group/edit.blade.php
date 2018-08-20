@extends('layouts.admin')

@section('content')

<h1 class="h2 mt-3">Edit: {{ $group->name }}</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit - {{ $group->name}}</div>

                <div class="card-body">

                        <form action="{{ route('update_group', ['id' => $group->id]) }}" method="POST" id="group-form">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            {{ method_field('PUT') }}
                            @csrf
                            @foreach($errors->all() as $message)
                                <p>{{ $message }} </p>
                            @endforeach
                            <div class="form-group">
                                <label for="group-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="group-name" name="name" value="{{ optional($group)->name }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="group-category" class="col-form-label">Category:</label>
                                <select class="form-control select2" id="group-category" name="category_id" style="width: 100%">
                                    <option value="">--choose group category--</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == optional($group->category)->id ? "selected" : ""}}>{{ $category->name }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="group-link" class="col-form-label">Link:</label>
                            <input type="text" class="form-control" id="group-link" placeholder="link" name="url" value="{{ optional($group)->url }}">
                            </div>

                            <button type="submit" class="btn btn-primary btn-md btn-block"> Update </button>
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
    })        
</script>

@endsection