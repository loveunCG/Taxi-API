@extends('account.layout.auth')

@section('content')
<div class="sign-form">
    <div class="row">
        <div class="col-md-4 offset-md-4 px-3">
            <div class="box b-a-0">
                <div class="p-2 text-xs-center">
                    <h5>Account Login</h5>
                </div>
                <form class="form-material mb-1" role="form" method="POST" action="{{ url('/account/login') }}" >
                {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" name="email" required="true" class="form-control" id="email" placeholder="Email">
                        @if ($errors->has('email'))
                            <span class="help-block" style="margin-left: 55px;color: red;">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password" name="password" required="true" class="form-control" id="password" placeholder="Password">
                        @if ($errors->has('password'))
                            <span class="help-block" style="margin-left: 55px;color: red;">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="px-2 form-group mb-0">
                        <input type="checkbox" name="remember"> Remember Me
                    </div>
                    <br>
                    <div class="px-2 form-group mb-0">
                        <button type="submit" class="btn btn-purple btn-block text-uppercase">Sign in</button>
                    </div>
                </form>
                <div class="p-2 text-xs-center text-muted">
                    <a class="text-black" href="{{ url('/account/password/reset') }}"><span class="underline">Forgot Your Password?</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
