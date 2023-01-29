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
                                <form action="{{route('assign_ticket_store',$id)}}" method="post" id='assignedUser'>
                                @csrf
                                <div class="card-title">
                                    <legend style="color: green; font-weight: bold;">
                                        Assign User
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
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-2">
                                        </div>
                                        <div class="col-md-12 text-center">
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