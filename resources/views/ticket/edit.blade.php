@extends('layout.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
            <div class="row mb-3 content-header">
                <div class="col-sm-6">
                </div>
            </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <form action="{{route('ticket_update',encrypt($ticketArr->id))}}" method="post" id='user'>
                                @csrf
                                <div class="card-title">
                                    <legend style="color: green; font-weight: bold;">
                                        Create Ticket
                                    </legend>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Alert message (start) -->
                                @if(Session::has('ticket_update'))
                                    <div class="alert {{ Session::get('alert-class') }}">
                                        {{ Session::get('ticket_update') }}
                                    </div>
                                @endif
                                <!-- Alert message (end) -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="ticket_no">Ticket No.</label>
                                            <input type="text" id="ticket_no" name="ticket_no" class="{{ ($errors->apply->has('ticket_no'))?'is-invalid form-control':'form-control' }}" placeholder="Enter Ticket Number" value="{{$ticketArr->ticket_no ?? NULL}}">
                                            @if ($errors->apply->has('ticket_no'))
                                                <span class="invalid-feedback">{{ $errors->apply->first('ticket_no') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="summery">Summery</label>
                                            <input type="text" name="summery" id="summery" class="{{ ($errors->apply->has('summery'))?'is-invalid form-control':'form-control' }}" placeholder="Enter Your summery" value="{{$ticketArr->summery ?? NULL}}">
                                            @if ($errors->apply->has('summery'))
                                                <span class="invalid-feedback">{{ $errors->apply->first('summery') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="qa_user_id">Assign Quality analysis</label>
                                            <select name="qa_user_id" id="qa_user_id" class="form-control">
                                                <option value="">-----Select QA -----</option>
                                                @foreach($qaUserList as $key => $role)
                                                <option value="{{$key}}" <?= (($key == $ticketArr->qa_user_id) ? "selected" : ""); ?>>{{$role}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->apply->has('qa_user_id'))
                                                <span class="invalid-feedback">{{ $errors->apply->first('qa_user_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dev_user_id">Assign Devolper</label>
                                            <select name="dev_user_id" id="dev_user_id" class="form-control">
                                                <option value="">-----Select Dev -----</option>
                                                @foreach($devUserData as $key => $role)
                                                <option value="{{$key}}" <?= (($key == $ticketArr->dev_user_id) ? "selected" : ""); ?>>{{$role}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->apply->has('dev_user_id'))
                                                <span class="invalid-feedback">{{ $errors->apply->first('dev_user_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>                                
                                <div class="row">                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Due Date</label>
                                            <div class="input-group date" id="reservationdate">
                                                <input type="text" name="due_date" class="{{ ($errors->apply->has('due_date')) ? 'is-invalid form-control':'form-control'}}" data-target="reservationdate" autocomplete="off" placeholder = "Select Due date" value="<?= $ticketArr->due_date ?? NULL ?>" />
                                                <div class="input-group-append input-group-text">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                @if ($errors->apply->has('due_date'))
                                                    <span class="invalid-feedback">{{ $errors->apply->first('due_date') }}</span>
                                                @endif
                                            </div>
                                        </div>                    
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="">-----Select ticket status -----</option>
                                                @foreach($ticketStatusArr as $key => $status)
                                                <option value="{{$key}}" <?= (($ticketArr->status == $key) ? "selected" : ""); ?>>{{$status}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->apply->has('status'))
                                                <span class="invalid-feedback">{{ $errors->apply->first('status') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="comment">Comment</label>
                                            <textArea type="text" name="comment" id="comment" class="{{ ($errors->apply->has('comment'))?'is-invalid form-control':'form-control' }}" value = "{{$ticketArr->comment ?? NULL}}" ></textArea>
                                            @if ($errors->apply->has('comment'))
                                                <span class="invalid-feedback">{{ $errors->apply->first('comment') }}</span>
                                            @endif
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-2">
                                        </div>
                                        <div class="col-md-12">
                                            <input type="submit" class="btn btn-primary mr-2" id = "form-submit" value="Submit">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('pagespecificscripts')
<script>
    //Date range picker
    $(function () {
        $('#reservationdate').datepicker({
            autoclose:true,
            format: 'yyyy-mm-dd',
            top: '229px'
        });
    });
</script>
@stop