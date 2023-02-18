@extends('layout.modalLayout')
@section('content')
<div class="row">
    <div class="alert">
    </div>
<div class="col-md-12">
    <div class="form-group">
        <label for="status">Change Ticket Status</label>
        <select name="status" id="status" class="form-control" onChange="changeStatus(this);">
            <option value="">-----Select ticket status -----</option>
            @foreach($ticketStatusArr as $key => $status)
            <option value="{{$key}}" <?= (($ticketArr->status == $key) ? "selected" : ""); ?>>{{$status}}</option>
            @endforeach
        </select>
    </div>
</div>
</div>

@stop

@section('pagespecificscripts')
<script>
    function changeStatus(obj) {

        var status = $(obj).val();
        var ticketId = "<?php echo $ticketArr->id ?>";
        if (!confirm('Do you want to change ticket status?')) {
            return false;
        }
        $.ajax({
            url: "{{route('update_ticket_status')}}",		
            type: 'POST',
            headers:{'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')},
            data: {'ticketId': ticketId,'status':status}  
        }).done(function (response) {
            var data = JSON.parse(response);        
            if (data.code == 200 && data.success == true) {
               $('.alert').addClass('alert-success')
               $('.alert').html(data.msg)
            }
            if (data.code == 500 && data.success == false) {
               $('.alert').addClass('alert-danger')
               $('.alert').html(data.msg)
            }
        });
    }
</script>