@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')

@include('layouts.partials.labs.header', ['title' => 'Dashboard'])

<div class="row">
    <div class="col-md-8">

        <div class="card">
        <div class="card-header">Manage Linked {{ $lab->name}} Tests</div>

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
                        <td>{{ $test->name }}</td>
                        <td>
                        <form action="{{ route('update_test_group', ['lab' => $lab->slug, 'test' => $test->id]) }}" method="POST" id="link_test_form_{{$test->id}}">
                                    @csrf
                                    {{ method_field('PUT') }}
                                    <select class="form-control" name="group_id" id="">
                                        <option value="">Select group</option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}" {{ $test->group_id == $group->id ? 'selected' : '' }}>{{ $group->name}}</option>
                                        @endforeach
                                    </select>
                            </form>
                            
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm link_lab_test_to_group" data-id="{{$test->id}}">Update</button>
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

        $('button.link_lab_test_to_group').click(function(e){
            
            e.preventDefault();

            $('form#link_test_form_' + $(this).data('id')).submit();
            
    
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