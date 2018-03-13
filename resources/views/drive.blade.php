@extends('user.layout.app')

@section('content')
<div class="banner row no-margin" style="background-image: url('{{ asset('asset/img/banner-bg.jpg') }}');">
    <div class="banner-overlay"></div>
    <div class="container">
        <div class="col-md-8">
            <h2 class="banner-head"><span class="strong">Work that puts you first</span><br>Drive when you want, make what you need</h2>
        </div>
        <div class="col-md-4">
            <div class="banner-form">
                <div class="row no-margin fields">
                    <div class="left">
                    	<img src="{{asset('asset/img/ride-form-icon.png')}}">
                    </div>
                    <div class="right">
                        <a href="{{url('provider/register')}}">
                            <h3>Sign up to drive</h3>
                            <h5>SIGN UP <i class="fa fa-chevron-right"></i></h5>
                        </a>
                    </div>
                </div>

                <div class="row no-margin fields">
                    <div class="left">
                    	<img src="{{asset('asset/img/ride-form-icon.png')}}">
                    </div>
                    <div class="right">
                        <a href="{{url('provider/login')}}">
                            <h3>Sign in to drive</h3>
                            <h5>SIGN IN <i class="fa fa-chevron-right"></i></h5>
                        </a>
                    </div>
                </div>

                <p class="note-or">Or <a href="{{ url('login') }}">sign in</a> with your rider account.</p>
            </div>
        </div>
    </div>
</div>

<div class="row white-section no-margin">
    <div class="container">
        
        <div class="col-md-4 content-block small">
            <h2>Set your own schedule</h2>
            <div class="title-divider"></div>
            <p>You can drive with {{ Setting::get('site_title', 'Tranxit') }} anytime, day or night, 365 days a year. When you drive is always up to you, so it never interferes with the important things in your life.</p>
        </div>

        <div class="col-md-4 content-block small">
            <h2>Make more at every turn</h2>
            <div class="title-divider"></div>
            <p>Trip fares start with a base amount, then increase with time and distance. And when demand is higher than normal, drivers make more.</p>
        </div>

        <div class="col-md-4 content-block small">
            <h2>Let the app lead the way</h2>
            <div class="title-divider"></div>
            <p>Just tap and go. You’ll get turn-by-turn directions, tools to help you make more, and 24/7 support—all available right there in the app.</p>
        </div>

    </div>
</div>

<div class="row gray-section no-margin full-section">
    <div class="container">                
        <div class="col-md-6 content-block">
            <h3>About the app</h3>
            <h2>Designed just for drivers</h2>
            <div class="title-divider"></div>
            <p>When you want to make money, just open the app and you’ll start to receive trip requests. You’ll get information about your rider and directions to their location and destination. When the trip is over, you’ll receive another nearby request. And if you're ready to get off the road, you can sign off at any time.</p>
            <a class="content-more-btn" href="#">SEE HOW IT WORKS <i class="fa fa-chevron-right"></i></a>
        </div>
        <div class="col-md-6 full-img text-center" style="background-image: url({{ asset('asset/img/driver-car.jpg') }});"> 
            <!-- <img src="img/anywhere.png"> -->
        </div>
    </div>
</div>

<div class="row white-section no-margin">
    <div class="container">
        
        <div class="col-md-4 content-block small">
            <h2>Rewards</h2>
            <div class="title-divider"></div>
            <p>You’re in the driver’s seat. So reward yourself with discounts on fuel, vehicle maintenance, cell phone bills, and more. Reduce your daily expenses and take home extra cash.</p>
        </div>

        <div class="col-md-4 content-block small">
            <h2>Requirements</h2>
            <div class="title-divider"></div>
            <p>Know you’re ready to hit the road. Whether you’re driving your own car or a commercially-licensed vehicle, you must meet the minimum requirements and complete a safety screening online.</p>
        </div>

        <div class="col-md-4 content-block small">
            <h2>Safety</h2>
            <div class="title-divider"></div>
            <p>When you drive with {{ Setting::get('site_title', 'Tranxit') }}, you get 24/7 driver support and insurance coverage. And all riders are verified with their personal information and phone number, so you’ll know who you’re picking up and so will we.</p>
        </div>

    </div>
</div>
            
<div class="row find-city no-margin">
    <div class="container">
        <h2>Start making money</h2>
        <p>Ready to make money? The first step is to sign up online.</p>

        <button type="submit" class="full-primary-btn drive-btn">START DRIVE NOW</button>
    </div>
</div>

<div class="footer-city row no-margin" style="background-image: url({{ asset('asset/img/footer-city.png') }});"></div>
@endsection