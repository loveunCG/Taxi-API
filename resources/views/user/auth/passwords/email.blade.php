@extends('user.layout.auth')

@section('content')

<?php $login_user = asset('asset/img/login-user-bg.jpg'); ?>
<div class="full-page-bg" style="background-image: url({{$login_user}});">
<div class="log-overlay"></div>
    <div class="full-page-bg-inner">
        <div class="row no-margin">
            <div class="col-md-6 log-left">
                <span class="login-logo"><img src="{{asset('asset/img/logo.png')}}"></span>
                <h2>Create your account and get moving in minutes</h2>
                <p>Welcome to {{ Setting::get('site_title', 'Tranxit')  }}, the easiest way to get around at the tap of a button.</p>
            </div>
            <div class="col-md-6 log-right">
                <div class="login-box-outer">
                <div class="login-box row no-margin">
                    <div class="col-md-12">
                        <a class="log-blk-btn" href="{{url('login')}}">ALREADY HAVE AN ACCOUNT?</a>
                        <h3>Reset Password</h3>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="col-md-12">
                            <input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif                        
                        </div>

                        
                        <div class="col-md-12">
                            <button class="log-teal-btn" type="submit">SEND PASSWORD RESET LINK</button>
                        </div>
                    </form>     

                    <div class="col-md-12">
                        <p class="helper">Or <a href="{{route('login')}}">Sign in</a> with your user account.</p>   
                    </div>

                </div>


                <div class="log-copy"><p class="no-margin">{{ Setting::get('site_copyright', '&copy; '.date('Y').' Appoets') }}</p></div>
                </div>
            </div>
        </div>
    </div>
@endsection
