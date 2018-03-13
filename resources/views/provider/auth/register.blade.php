@extends('provider.layout.auth')

@section('content')
<div class="col-md-12">
    <a class="log-blk-btn" href="{{ url('/provider/login') }}">ALREADY REGISTERED?</a>
    <h3>Sign Up</h3>
</div>

<div class="col-md-12">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/provider/register') }}">

        <div id="first_step">
            <div class="col-md-4">
                <input value="+91" type="text" placeholder="+91" id="country_code" name="country_code" />
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

            <input id="name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" autofocus>

            @if ($errors->has('first_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('first_name') }}</strong>
                </span>
            @endif

            <input id="name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name">

            @if ($errors->has('last_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
            @endif

            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail Address">

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif

            <label class="checkbox-inline"><input type="checkbox" name="gender" value="MALE">Male</label>
            <label class="checkbox-inline"><input type="checkbox" name="gender" value="FEMALE">Female</label>
            @if ($errors->has('gender'))
                <span class="help-block">
                    <strong>{{ $errors->first('gender') }}</strong>
                </span>
            @endif                        

            <input id="password" type="password" class="form-control" name="password" placeholder="Password">

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif

            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">

            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif

            <select class="form-control" name="service_type" id="service_type">
                <option value="">Select Service</option>
                @foreach(get_all_service_types() as $type)
                    <option value="{{$type->id}}">{{$type->name}}</option>
                @endforeach
            </select>

            @if ($errors->has('service_type'))
                <span class="help-block">
                    <strong>{{ $errors->first('service_type') }}</strong>
                </span>
            @endif

            <input id="service-number" type="text" class="form-control" name="service_number" value="{{ old('service_number') }}" placeholder="Car Number">

            @if ($errors->has('service_number'))
                <span class="help-block">
                    <strong>{{ $errors->first('service_number') }}</strong>
                </span>
            @endif

            <input id="service-model" type="text" class="form-control" name="service_model" value="{{ old('service_model') }}" placeholder="Car Model">

            @if ($errors->has('service_model'))
                <span class="help-block">
                    <strong>{{ $errors->first('service_model') }}</strong>
                </span>
            @endif

            <button type="submit" class="log-teal-btn">
                Register
            </button>

        </div>
    </form>
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