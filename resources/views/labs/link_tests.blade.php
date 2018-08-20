@extends('layouts.admin')

@section('content')

@include('layouts.partials.labs.header', ['title' => 'Dashboard'])

<div class="row">
    <div class="col-md-10">

        <div class="card">
        <div class="card-header">Link {{ $lab->name}} Tests</div>

            <div class="card-body">

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
                            <th scope="col">Select Test</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groups as $group)  
                        <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td  style="width:30%">{{ $group->name }}</td>
                        <td>
                            <form action="{{ route('update_group_test', ['lab' => $lab->slug, 'group' => $group->id]) }}" method="POST" id="link_group_form_{{$group->id}}">
                                    @csrf
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                                    <select class="form-control select2" name="test_id" style="width: 100%">
                                        <option value="">Select test</option>
                                        {{-- @foreach($tests as $test)
                                            <option value="{{ $test->id }}">{{ $test->name}}</option>
                                        @endforeach --}}
                                    </select>
                            </form>
                            
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm link_lab_group_to_test" data-id="{{$group->id}}">Link</button>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
            </div>
        </div>
    </div>
    
</div>
{{-- <div class="row">
    <div class="col-md-10">

        <div class="card">
        <div class="card-header">Link {{ $lab->name}} Tests</div>

            <div class="card-body">

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
                            <th scope="col">Select Group</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tests as $test)  
                        <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td  style="width:50%">{{ $test->name }}</td>
                        <td>
                        <form action="{{ route('update_test_group', ['lab' => $lab->slug, 'test' => $test->id]) }}" method="POST" id="link_test_form_{{$test->id}}">
                                    @csrf
                                    {{ method_field('PUT') }}
                                    <select class="form-control select2" name="group_id" style="width: 100%">
                                        <option value="">Select group</option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}">{{ $group->name}}</option>
                                        @endforeach
                                    </select>
                            </form>
                            
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm link_lab_test_to_group" data-id="{{$test->id}}">Link</button>
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
    
</div> --}}



@endsection


@section('scripts')

<script>

    $(document).ready(function(){
        var data = [];

        $.ajax({
            type: "GET",
            url:  "{{ route('get_lab_tests', ['lab' => $lab->slug]) }}",
            success: function( response ) {
                data = response;
            },
            error: function(xhr,status,error){
                console.log(status)
                console.log(error)
            }
            
        });
        
        $('.select2').mouseover(function(e){
            e.preventDefault();
            $(this).select2({
                data: data
            })
        })

        

        

        $('button.link_lab_test_to_group').click(function(e){
            
            e.preventDefault();

            $('form#link_test_form_' + $(this).data('id')).submit();
            
    
        });
        $('button.link_lab_group_to_test').click(function(e){
            
            e.preventDefault();

            $('form#link_group_form_' + $(this).data('id')).submit();
            
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