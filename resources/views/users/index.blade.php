@extends('layouts.admin')


@section('styles')


@endsection

@section('content')
    
<h1 class="h2 mt-3">Manage users</h1>
    <div class="row">
        <div class="col-md-10">

            <div class="modal fade" id="assignLabModal" role="dialog" aria-labelledby="assignLabModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="assignLabModalLabel">Select Lab</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            
                            <form action="" method="POST" id="assign_lab">
                                {{ method_field('PUT') }}
                                @csrf
                                @foreach($errors->all() as $message)
                                    <p>{{ $message }} </p>
                                @endforeach
                                
                                <div class="form-group">
                                    <label for="group-synlab" class="col-form-label">Laboratories:</label>
                                    <select class="form-control select2" id="lab-id" name="lab_id" style="width: 100%">
                                            <option value="">--choose lab--</option>
                                            @foreach($labs as $lab)
                                                <option value="{{ $lab->id }}">{{ $lab->name }}</option>
                                            @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Continue</button>
                                
                            </form>

                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                        <div class="row justify-content-center mb-3">
                            <div class="col-md-12">

                            {{-- <a class="btn btn-secondary float-right" data-toggle="modal" data-target="#groupModal" data-title="Add new group" data-submit-text="Create group" data-url="group/create" data-method="POST">New Group</button> --}}
                            {{-- <a class="btn btn-secondary float-right"  href="{{ route('create_group') }}" title="new group">Create New Group</a> --}}
                            </div>
                        </div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="unassign_lab" action="" method="POST" style="display: none;">
                        {{ method_field('PUT') }}
                        @csrf
                        }
                    </form>
                    <form class="approve_lab" action="" method="POST" style="display: none;">
                        {{ method_field('PUT') }}
                        @csrf
                        }
                    </form>
                    <form class="unapprove_lab" action="" method="POST" style="display: none;">
                        {{ method_field('PUT') }}
                        @csrf
                        }
                    </form>
                    <form class="delete_user" action="" method="POST" style="display: none;">
                        {{ method_field('DELETE') }}
                        @csrf
                        }
                    </form>    
                    <table class="table table-bordered" id="group-table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Lab</th>
                            <th scope="col">Confirmed</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($users as $user)  
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $user->name }} {{ $user->isAdmin ? '(admin)' : ''}}</td>
                                <td>{{ $user->email }}</td>
                                <td> {{ optional($user->lab)->name }} </td>
                                <td> 
                                    @if($user->lab)
                                        {{ optional($user->lab)->confirmed ? 'Confirmed' : 'Pending' }} 
                                    @else
                                        {{ 'Not linked' }} 
                                    @endif    
                                </td>
                                <td>
                                    
                                    @if($user->lab)    
                                        <button type="button" class="btn btn-secondary btn-sm unassign_lab" data-url="users/{{$user->id}}/unassign">Unlink</button>
                                        @if(!$user->lab->confirmed)
                                        
                                        <button type="button" class="btn btn-secondary btn-sm approve_lab" data-url="users/{{$user->id}}/approve">Approve</button>
                                        @else
                                        
                                            <button type="button" class="btn btn-secondary btn-sm unapprove_lab" data-url="users/{{$user->id}}/unapprove">Unapprove</button>
                                        @endif

                                    @else
                                    <button class="btn btn-secondary btn-sm assign_lab" data-href="{{ route('assign_lab', ['user' => $user->id]) }}" target="_blank">Assign Lab</button>
                                    @endif
                                    
                                    <button type="button" class="btn btn-secondary btn-sm delete_user"  data-title="Delete user" data-submit-text="Delete" data-url="users/{{$user->id}}">Delete</button>
                                </td>
                                
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                    <div class="float-right">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('scripts')

<script>

    $(document).ready(function(){


        $('button.delete_user').click(function(e){
            
            e.preventDefault();
            
            $("form.delete_user").attr('action', $(this).data('url'));
            
            $("form.delete_user").submit();

        });
        
        $('button.approve_lab').click(function(e){
            
            e.preventDefault();
            
            $("form.approve_lab").attr('action', $(this).data('url'));
            
            $("form.approve_lab").submit();

        });
        
        $('button.unapprove_lab').click(function(e){
            
            e.preventDefault();
            
            $("form.unapprove_lab").attr('action', $(this).data('url'));
            
            $("form.unapprove_lab").submit();

        });
        
        $('button.unassign_lab').click(function(e){
            
            e.preventDefault();
            
            $("form.unassign_lab").attr('action', $(this).data('url'));
            
            $("form.unassign_lab").submit();

        });
        
        $('button.assign_lab').click(function(e){
            
            e.preventDefault();
            
            $("form#assign_lab").attr('action', $(this).data('href'));

            $('#assignLabModal').modal('show');

        });
        
    });
     
</script>

@endsection