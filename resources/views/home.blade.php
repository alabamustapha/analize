@extends('layouts.app')

@section('content')


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">

            
            <div class="modal fade" id="groupModal" role="dialog" aria-labelledby="groupModalLabel" aria-hidden="true">
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
            </div>

            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                        <div class="row justify-content-center mb-3">
                            <div class="col-md-12">
                        
                            <form id="synevo-form" action="{{ route('synevo') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            
                            <form id="synlab-form" action="{{ route('synlab') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            
                            <form id="reginamaria-form" action="{{ route('reginamaria') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            
                            <form id="medlife-form" action="{{ route('medlife') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            
                            <button type="button" class="btn btn-primary"
                                    onclick="event.preventDefault();
                                    document.getElementById('synevo-form').submit();">
                            synevo</button>

                            <button type="button" class="btn btn-info"
                            onclick="event.preventDefault();
                            document.getElementById('synlab-form').submit();">
                            synlab</button>

                             <button type="button" class="btn btn-success"
                                    onclick="event.preventDefault();
                                    document.getElementById('reginamaria-form').submit();">
                            reginamaria</button>
                            
                            <button type="button" class="btn btn-warning"
                            onclick="event.preventDefault();
                            document.getElementById('medlife-form').submit();">
                            medlife</button>

                            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Open modal for @mdo</button> --}}
                            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Open modal for @fat</button> --}}
                            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Open modal for @getbootstrap</button> --}}

                            
                            <button type="button" class="btn btn-secondary float-right" data-toggle="modal" data-target="#groupModal" data-title="Add new group" data-submit-text="Create group" data-url="group/create" data-method="POST">New Group</button>
                            </div>
                        </div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Synevo</th>
                            <th scope="col">Synlab</th>
                            <th scope="col">reginamaria</th>
                            <th scope="col">medlife</th>
                            <th scope="col">Link</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($groups as $group)  
                          <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $group->name or ''}}</td>
                            <td>{{ $group->synevo->name or '' }} ({{ $group->synevo->price or '0.00'}})</td>
                            <td>{{ $group->synlab->name or ''}} ({{ $group->synlab->price or '0.00' }})</td>
                            <td>{{ $group->reginamaria->name or '' }} ({{ $group->reginamaria->price or '0.00' }})</td>
                            <td>{{ $group->medlife->name or '' }} ({{ $group->medlife->price or '0.00' }})</td>
                            <td><a href="{{ $group->url or '#' }}" title="{{ $group->url or '#' }}" class="btn btn-link">View post</a></td>
                            <td>
                                <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#groupModal" data-title="Update group" data-submit-text="Update" data-url="groups/{{$group->id}}" data-method="PUT">Edit</button>

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

                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('script')

<script>

    $(document).ready(function(){
        $('.select2').select2();

        $('button.delete_group').click(function(e){
            
            e.preventDefault();
            
            $("form.delete_group").attr('action', $(this).data('url'))
            
            $("form.delete_group").submit()

            alert('/' + $("form.delete_group").attr('action'))
        })
    });
    $(document).ready(function(){
        $('#groupModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var title = button.data('title') // Extract info from data-* attributes
            var submit_btn_text = button.data('submit-text') // Extract info from data-* attributes
            var url = button.data('url') // Extract info from data-* attributes
            var method = button.data('method') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text(title)
            // modal.find('.modal-body input').val(title)
            modal.find('.modal-footer button#groupModalSubmit').text(submit_btn_text)
            $("form#group-form").attr('action', url)
            $("form#group-form").attr('method', method)
            $("button#groupModalSubmit").click(function(){
                document.getElementById('group-form').submit()
            })
        })
    });        
</script>

@endsection