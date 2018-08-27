@extends('layouts.public')

@section('content')



<div class="row justify-content-center mt-3">
    
    <div class="col-md-6">

            <form action="{{ route('store_lab') }}" method="POST" id="lab-form">
                    @csrf
                    @foreach($errors->all() as $message)
                        <p>{{ $message }} </p>
                    @endforeach
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <div class="form-group">
                        <label for="lab-name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="lab-name" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="lab-short-name" class="col-form-label">Short Name:</label>
                        <input type="text" class="form-control" id="lab-short-name" name="short_name" value="{{ old('short_name') }}">
                    </div>
                    <div class="form-group">
                        <label for="lab-url" class="col-form-label">Url:</label>
                        <input type="text" class="form-control" id="lab-url" name="url" value="{{ old('url') }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Continue</button>

                </form>
        
    </div>
    
</div>



@endsection


@section('scripts')

<script>

    $(document).ready(function(){
        $('.select2').select2();

        $('button.delete_lab').click(function(e){
            
            e.preventDefault();
            
            $("form.delete_lab").attr('action', $(this).data('url'))
            
            $("form.delete_lab").submit()
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