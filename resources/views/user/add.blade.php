@extends('layout.admin')
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
            <div class="row mb-2 content-header">
                <div class="col-sm-6">
                </div>
            </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <form action="{{route('user_store')}}" method="post" id='user'>
                                @csrf
                                <div class="card-title">
                                    <legend style="color: green; font-weight: bold;">
                                        Create User
                                    </legend>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Alert message (start) -->
                                @if(Session::has('user_update'))
                                    <div class="alert {{ Session::get('alert-class') }}">
                                        {{ Session::get('user_update') }}
                                    </div>
                                @endif
                                <!-- Alert message (end) -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="first-name">Name</label>
                                            <input type="text" id="name" name="name" class="{{ ($errors->apply->has('name'))?'is-invalid form-control':'form-control' }}" placeholder="Enter Your Full Name" value="{{old('name')}}">
                                            @if ($errors->apply->has('name'))
                                                <span class="invalid-feedback">{{ $errors->apply->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Email">Email</label>
                                            <input type="text" name="email" id="email" class="{{ ($errors->apply->has('email'))?'is-invalid form-control':'form-control' }}" placeholder="Enter Your Email" value="{{old('email')}}">
                                            @if ($errors->apply->has('email'))
                                                <span class="invalid-feedback">{{ $errors->apply->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="text" name="password" id="password" class="{{ ($errors->apply->has('password'))?'is-invalid form-control':'form-control' }}" placeholder="Enter the password" >
                                            @if ($errors->apply->has('password'))
                                                <span class="invalid-feedback">{{ $errors->apply->first('password') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div>
                                                <label for="lname">Gender:</label>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input class="{{ ($errors->apply->has('gender'))?'is-invalid custom-control-input':'custom-control-input' }}" type="radio" id="male" name="gender" value = "1" <?php echo (old('gender') == 1)? "checked":"" ?>>
                                                    <label class="custom-control-label" for="male">Male</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input class="{{ ($errors->apply->has('gender'))?'is-invalid custom-control-input':'custom-control-input' }}" type="radio" id="female" name="gender" value = "2" <?php echo (old('gender') == 2)? "checked":"" ?>>
                                                    <label class="custom-control-label" for="female">Female</label>
                                                </div>
                                                @if ($errors->apply->has('gender'))
                                                <span class="invalid-feedback" style="display:block;">{{ $errors->apply->first('gender') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="roles">User Role</label>
                                            <select name="role" id="role" class="form-control">
                                                <option value="">-----Select User role-----</option>
                                                @foreach($userRoleArr as $key => $role)
                                                <option value="{{$key}}">{{$role}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->apply->has('roles'))
                                                <span class="invalid-feedback">{{ $errors->apply->first('roles') }}</span>
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