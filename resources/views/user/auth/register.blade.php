@extends('user.layout.auth')

@section('content')

<?php $login_user = asset('asset/img/login-user-bg.jpg'); ?>
<div class="full-page-bg" style="background-image: url({{$login_user}});">
<div class="log-overlay"></div>
    <div class="full-page-bg-inner">
        <div class="row no-margin">
            <div class="col-md-6 log-left">
                <span class="login-logo"><img src="{{ Setting::get('site_logo', asset('logo-black.png'))}}"></span>
                <h2>Create your account and get moving in minutes</h2>
                <p>Welcome to {{Setting::get('site_title','Tranxit')}}, the easiest way to get around at the tap of a button.</p>
            </div>
            <div class="col-md-6 log-right">
                <div class="login-box-outer">
                <div class="login-box row no-margin">
                    <div class="col-md-12">
                        <a class="log-blk-btn" href="{{url('login')}}">ALREADY HAVE AN ACCOUNT?</a>
                        <h3>Create a New Account</h3>
                    </div>
                    <form role="form" method="POST" action="{{ url('/register') }}">

                        <div id="first_step">
                            <div class="col-md-4">
                                <input value="+91" type="text" placeholder="+1" id="country_code" name="country_code" />
                            </div> 
                            
                            <div class="col-md-8">
                                <input type="text" autofocus id="phone_number" class="form-control" placeholder="Enter Phone Number" name="phone_number" value="{{ old('phone_number') }}" />
                            </div>

                            <div class="col-md-8">
                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12" style="padding-bottom: 10px;" id="mobile_verfication">
                                <input type="button" class="log-teal-btn small" onclick="smsLogin();" value="Verify Phone Number"/>
                            </div>

                        </div>

                        {{ csrf_field() }}

                        <div id="second_step" style="display: none;">

                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="First Name" name="first_name" value="{{ old('first_name') }}">

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}">

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif                        
                            </div>

                            <div class="col-md-12">
                                <label class="checkbox-inline"><input type="checkbox" name="gender" value="MALE">Male</label>
                                <label class="checkbox-inline"><input type="checkbox" name="gender"  value="FEMALE">Female</label>
                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif                        
                            </div>

                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password" placeholder="Password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <input type="password" placeholder="Re-type Password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="col-md-12">
                                <button class="log-teal-btn" type="submit">REGISTER</button>
                            </div>

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


@section('scripts')
<script type="text/javascript">
    $('.checkbox-inline').on('change', function() {
        $('.checkbox-inline').not(this).prop('checked', false);  
    });
</script>
<script src="https://sdk.accountkit.com/en_US/sdk.js"></script>
<script>
  // initialize Account Kit with CSRF protection
  AccountKit_OnInteractive = function(){
    AccountKit.init(
      {
        appId: {{env('FB_APP_ID')}}, 
        state:"state", 
        version: "{{env('FB_APP_VERSION')}}",
        fbAppEventsEnabled:true
      }
    );
  };

  // login callback
  function loginCallback(response) {
    if (response.status === "PARTIALLY_AUTHENTICATED") {
      var code = response.code;
      var csrf = response.state;
      // Send code to server to exchange for access token
      $('#mobile_verfication').html("<p class='helper'> * Phone Number Verified </p>");
      $('#phone_number').attr('readonly',true);
      $('#country_code').attr('readonly',true);
      $('#second_step').fadeIn(400);

      $.post("{{route('account.kit')}}",{ code : code }, function(data){
        $('#phone_number').val(data.phone.national_number);
        $('#country_code').val('+'+data.phone.country_prefix);
      });

    }
    else if (response.status === "NOT_AUTHENTICATED") {
      // handle authentication failure
      $('#mobile_verfication').html("<p class='helper'> * Authentication Failed </p>");
    }
    else if (response.status === "BAD_PARAMS") {
      // handle bad parameters
    }
  }

  // phone form submission handler
  function smsLogin() {
    var countryCode = document.getElementById("country_code").value;
    var phoneNumber = document.getElementById("phone_number").value;

    $('#mobile_verfication').html("<p class='helper'> Please Wait... </p>");
    $('#phone_number').attr('readonly',true);
    $('#country_code').attr('readonly',true);

    AccountKit.login(
      'PHONE', 
      {countryCode: countryCode, phoneNumber: phoneNumber}, // will use default values if not specified
      loginCallback
    );
  }

</script>

@endsection
