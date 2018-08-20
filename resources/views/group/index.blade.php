@extends('layouts.admin')


@section('styles')


@endsection

@section('content')
    
<h1 class="h2 mt-3">Manage Groups</h1>
    <div class="row">
        <div class="col-md-10">

            
            {{-- <div class="modal fade" id="groupModal" role="dialog" aria-labelledby="groupModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="groupModalLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="" id="group-form">
                                @csrf
                                @foreach($errors->all() as $message)
                                    <p>{{ $message }} </p>
                                @endforeach
                                <div class="form-group">
                                    <label for="group-name" class="col-form-label">Name:</label>
                                    <input type="text" class="form-control" id="group-name" name="name">
                                </div>
                                
                                <div class="form-group">
                                    <label for="group-synevo" class="col-form-label">Synevo:</label>
                                    <select class="form-control select2" id="group-synevo" name="synevo_id" style="width: 100%">
                                            <option value="">--choose synevo product--</option>
                                            @foreach($synevos as $synevo)
                                                <option value="{{ $synevo->id }}">{{ $synevo->name }} - ({{ $synevo->price }})</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="group-synlab" class="col-form-label">Synlab:</label>
                                    <select class="form-control select2" id="group-synlab" name="synlab_id" style="width: 100%">
                                            <option value="">--choose synlab product--</option>
                                            @foreach($synlabs as $synlab)
                                                <option value="{{ $synlab->id }}">{{ $synlab->name }} - ({{ $synlab->price }})</option>
                                            @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="group-reginamaria" class="col-form-label">Reginamaria:</label>
                                    <select class="form-control select2" id="group-reginamaria" name="reginamaria_id" style="width: 100%">
                                            <option value="">--choose reginamaria product--</option>
                                            @foreach($reginamarias as $reginamaria)
                                                <option value="{{ $reginamaria->id }}">{{ $reginamaria->name }} - ({{ $reginamaria->price }})</option>
                                            @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="medlife-link" class="col-form-label">Medlife:</label>
                                    <select class="form-control select2" id="group-medlife" name="medlife_id" style="width: 100%">
                                        <option value="">--choose medlife product--</option>
                                        @foreach($medlives as $medlife)
                                            <option value="{{ $medlife->id }}">{{ $medlife->name }} - ({{ $medlife->price }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="group-category" class="col-form-label">Category:</label>
                                    <select class="form-control select2" id="group-category" name="category_id" style="width: 100%">
                                        <option value="">--choose group category--</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="group-link" class="col-form-label">Link:</label>
                                    <input type="text" class="form-control" id="group-link" placeholder="link" name="url">
                                </div>
                            </form>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="groupModalSubmit"></button>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                        <div class="row justify-content-center mb-3">
                            <div class="col-md-12">

                            {{-- <a class="btn btn-secondary float-right" data-toggle="modal" data-target="#groupModal" data-title="Add new group" data-submit-text="Create group" data-url="group/create" data-method="POST">New Group</button> --}}
                            <a class="btn btn-secondary float-right"  href="{{ route('create_group') }}" title="new group">Create New Group</a>
                            </div>
                        </div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <table class="table table-bordered" id="group-table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Labs count</th>
                            <th scope="col">Link</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($groups as $group)  
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $group->name or ''}}</td>
                                <td> 0 </td>
                                <td><a href="{{ $group->url or '#' }}" title="{{ $group->url or '#' }}" class="btn btn-link">View post</a></td>
                                <td>
                                    <a class="btn btn-secondary btn-sm" href="{{ route('edit_group', ['group' => $group->id]) }}" target="_blank">View</a>
                                    <a class="btn btn-secondary btn-sm" href="{{ route('edit_group', ['group' => $group->id]) }}" target="_blank">Edit</a>
                                    <form class="delete_group" action="" method="POST" style="display: none;">
                                        {{ method_field('DELETE') }}
                                        @csrf
                                        }
                                    </form>
                                    <button type="button" class="btn btn-secondary btn-sm delete_group"  data-title="Delete group" data-submit-text="Delete" data-url="groups/{{$group->id}}">Delete</button>
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                    <div class="float-right">
                        {{ $groups->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('scripts')

<script>

    $(document).ready(function(){

        $("#group-table").DataTable();

        $('.select2').select2();

        $('button.delete_group').click(function(e){
            
            e.preventDefault();
            
            $("form.delete_group").attr('action', $(this).data('url'));
            
            $("form.delete_group").submit();

        });
        
    });
     
</script>

@endsection