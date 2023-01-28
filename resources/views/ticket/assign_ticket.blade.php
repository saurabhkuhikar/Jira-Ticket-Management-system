@extends('layout.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
            <div class="row mb-5 content-header">
                <div class="col-sm-6">
                </div>
            </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <form action="{{route('ticket_store')}}" method="post" id='user'>
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
                                            <input type="text" id="ticket_no" name="ticket_no" class="{{ ($errors->apply->has('ticket_no'))?'is-invalid form-control':'form-control' }}" placeholder="Enter Ticket Number" value="{{old('ticket_no')}}">
                                            @if ($errors->apply->has('ticket_no'))
                                                <span class="invalid-feedback">{{ $errors->apply->first('ticket_no') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="summery">Summery</label>
                                            <input type="text" name="summery" id="summery" class="{{ ($errors->apply->has('summery'))?'is-invalid form-control':'form-control' }}" placeholder="Enter Your summery" value="{{old('summery')}}">
                                            @if ($errors->apply->has('summery'))
                                                <span class="invalid-feedback">{{ $errors->apply->first('summery') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Due Date</label>
                                            <div class="input-group date" id="reservationdate">
                                                <input type="text" name="due_date" class="{{ ($errors->apply->has('due_date')) ? 'is-invalid form-control':'form-control'}}" data-target="reservationdate" autocomplete="off" placeholder = "Select Due date" value="<?= old('due_date') ?>" />
                                                <div class="input-group-append" data-target="reservationdate" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                                @if ($errors->apply->has('due_date'))
                                                    <span class="invalid-feedback">{{ $errors->apply->first('due_date') }}</span>
                                                @endif
                                            </div>
                                        </div>                    
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="comment">Comment</label>
                                            <textArea type="text" name="comment" id="comment" class="{{ ($errors->apply->has('comment'))?'is-invalid form-control':'form-control' }}" ></textArea>
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

@stop