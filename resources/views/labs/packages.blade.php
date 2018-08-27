@extends('layouts.admin')

@section('content')


@include('layouts.partials.labs.header', ['title' => 'Packages'])


<div class="modal fade" id="packageModal" role="dialog" aria-labelledby="packageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="packageModalLabel">Create new package</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        

                    <form action="{{ route('add_lab_package', ['lab' => $lab->slug]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="col-form-label">Package name:</label>
                            <input class="form-control" name="name" id="name">    
                        </div>
                        
                        <div class="form-group">
                            <label for="tests" class="col-form-label">Select Tests:</label>
                            <select class="form-control select2" name="groups[]" multiple id="tests" style="width: 100%">
                                <option>--select group--</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="price" class="col-form-label">Package price:</label>
                            <input class="form-control" name="price" id="price">    
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add package</button>
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
    <div class="col-md-10">


        <div class="card">

            <div class="card-header">Manage {{ $lab->name}} Packages</div>

            <div class="card-body">

                
                    <div class="row justify-content-center mb-3">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary float-right" data-toggle="modal" data-target="#packageModal">Add Package</button>
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
                <table class="table table-bordered" id="linkTests">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Tests in package</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $package)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
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
                            <td>
                                    {{-- <a class="btn btn-secondary btn-sm" href="{{ route('show_lab', ['lab' => $lab->slug]) }}" target="_blank">View</a> --}}
                                    <a class="btn btn-secondary btn-sm" href="{{ route(auth()->user()->isAdmin ? 'edit_lab_package' : 'user_edit_lab_package', ['lab' => $lab->slug, 'package' => $package->id]) }}" target="_blank">Edit</a>
        
                                    <form class="delete_lab_package" action="" method="POST" style="display: none;">
                                        {{ method_field('DELETE') }}
                                        @csrf
                                    </form>
                                    <button type="button" class="btn btn-secondary btn-sm delete_lab_package" data-url="{{ route('delete_lab_package', ['lab' => $lab->slug, 'package' => $package->id]) }}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                    <div class="float-right">
                    
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

        $('button.delete_lab_package').click(function(e){
            
            e.preventDefault();
            
            $("form.delete_lab_package").attr('action', $(this).data('url'))
            
            $("form.delete_lab_package").submit()
        });

    });

    
</script>

@endsection