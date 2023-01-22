@extends('layout.login')
@section('content')

<div class="hold-transition login-page" >
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h3>Login</h3>
            </div>
            @if (\Session::has('loginError'))
                <div class="alert alert-danger">
                    <span>{!! \Session::get('loginError') !!}</span>    
                </div>
            @endif
            <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form class="form-horizontal" action ="{{route('user_authenticate')}}" method = "post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="{{ ($errors->apply->has('email')) ? 'is-invalid form-control':'form-control'}}" name="email" id="email" placeholder="Email" value = "<?= old('email') ?>">                
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @if ($errors->apply->has('email'))
                    <span class="invalid-feedback">{{ $errors->apply->first('email') }}</span>
                @endif
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="{{ ($errors->apply->has('password')) ? 'is-invalid form-control':'form-control'}} " name="password" id="password" placeholder="Password">                
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
                @if ($errors->apply->has('password'))
                    <span class="invalid-feedback">{{ $errors->apply->first('password') }}</span>
                @endif
                </div>
                <div class="row">
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
                </div>
            </form>

            <div class="social-auth-links text-center mt-2 mb-3">
                <a href="#" class="btn btn-block btn-primary">
                <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                </a>
                <a href="#" class="btn btn-block btn-danger">
                <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                </a>
            </div>
            <!-- /.social-auth-links -->

            <p class="mb-1">
                <a href="#">I forgot my password</a>
            </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<!-- /.login-box -->

@stop

@section('pagespecificscripts')

@stop
