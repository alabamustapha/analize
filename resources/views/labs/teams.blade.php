@extends('layouts.admin')

@section('styles')

    
@endsection


@section('content')

@include('layouts.partials.labs.header', ['title' => 'Teams'])

    
<div class="row">
                
    <div class="col-md-7">


        <div class="card">
            <div class="card-header">Update {{ $lab->name }} Bio</div>

            <div class="card-body">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @foreach($errors->all() as $message)
                    <p>{{ $message }} </p>
                @endforeach
                <form class="delete_team" action="" method="POST" style="display: none;">
                    {{ method_field('DELETE') }}
                    @csrf
                    }
                </form>
                <table class="table ">
                    <thead>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Avatar</th>
                        <th>Rank</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($lab->teams as $team)
                            <tr>
                                <td>{{ $team->name }}</td>
                                <td>{{ $team->title }}</td>
                                <td><img src="{{ $team->avatar }}" width="50"></td>
                                <td>{{ $team->rank }}</td>
                                <td>
                                        <button type="button" class="btn btn-secondary btn-sm delete_team" data-submit-text="Delete" data-url="teams/{{$team->id}}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="col-md-5">


        <div class="card">
            <div class="card-header">Add {{ $lab->name }} team</div>

            <div class="card-body justify-content-center">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @foreach($errors->all() as $message)
                    <p>{{ $message }} </p>
                @endforeach
                

                <div class="row justify-content-center">
                    <div class="col">
                        <form action="{{ route('add_team_member', $lab->slug) }}" method="POST" id="lab-team" enctype="multipart/form-data">
                            @csrf
                            
                            @foreach($errors->all() as $message)
                                <p>{{ $message }} </p>
                            @endforeach
                        
                            <input type="hidden" name="lab_id" value="{{ $lab->id }}">
                            
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name='name'>
                            </div>    
                        
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name='title'>
                            </div>    
                            
                            <div class="form-group">
                                <label for="rank">Rank:</label>
                                <input type="text" class="form-control" id="rank" name='rank'>
                            </div>    
                            
                            <div class="form-group">
                                <label for="vatar">Avatar:</label>
                                <input type="file" class="form-control" id="avatar" name='avatar'>
                            </div>    

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Continue </button>
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
    
$('button.delete_team').click(function(e){
            
            e.preventDefault();
        
            alert("deleting..");
            $("form.delete_team").attr('action', $(this).data('url')).submit();
            
            
        });
        
</script>
@endsection