@extends('layouts.admin')

@section('content')


@include('layouts.partials.labs.header', ['title' => 'Packages'])

<div class="row">
    <div class="col-md-10">


        <div class="card">

            <div class="card-header">Manage {{ $lab->name}} Packages</div>

            <div class="card-body">

                
                    
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @foreach($errors->all() as $message)
                    <p>{{ $message }} </p>
                @endforeach
             
                <form action="{{ route('update_lab_package', ['lab' => $lab->slug, 'package' => $package->id]) }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="name" class="col-form-label">Package name:</label>
                            <input class="form-control" name="name" id="name" value="{{ $package->name }}">    
                        </div>
                        
                        <div class="form-group">
                            <label for="tests" class="col-form-label">Select Tests:</label>
                            <select class="form-control select2" name="groups[]" multiple id="tests" style="width: 100%">
                                <option>--select group--</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" {{ in_array($group->id, $selected_group) ? 'selected' : '' }}>{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="price" class="col-form-label">Package price:</label>
                            <input class="form-control" name="price" id="price" value="{{ $package->price }}">    
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
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

        $('button.delete_lab_package').click(function(e){
            
            e.preventDefault();
            
            $("form.delete_lab_package").attr('action', $(this).data('url'))
            
            $("form.delete_lab_package").submit()
        });

    });

    
</script>

@endsection