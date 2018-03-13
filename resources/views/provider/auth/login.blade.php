@extends('provider.layout.auth')

@section('content')
<div class="col-md-12">
    <a class="log-blk-btn" href="{{ url('/provider/register') }}">CREATE NEW ACCOUNT</a>
    <h3>Sign In</h3>
</div>

<div class="col-md-12">
    <form role="form" method="POST" action="{{ url('/provider/login') }}">
        {{ csrf_field() }}

        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" autofocus>

        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif

        <input id="password" type="password" class="form-control" name="password" placeholder="Password">

        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif

        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember">Remember Me
            </label>
        </div>

        <br>

        <button type="submit" class="log-teal-btn">
            Login
        </button>

        <p class="helper"><a href="{{ url('/provider/password/reset') }}">Forgot Your Password?</a></p>   
    </form>
    @if(Setting::get('social_login', 0) == 1)
    <div class="col-md-12">
        <a href="{{ url('provider/auth/facebook') }}"><button type="submit" class="log-teal-btn fb"><i class="fa fa-facebook"></i>LOGIN WITH FACEBOOK</button></a>
    </div>  
    <!-- <div class="col-md-12">
        <a href="{{ url('provider/auth/google') }}"><button type="submit" class="log-teal-btn gp"><i class="fa fa-google-plus"></i>LOGIN WITH GOOGLE+</button></a>
    </div> -->
    @endif
</div>
@endsection
