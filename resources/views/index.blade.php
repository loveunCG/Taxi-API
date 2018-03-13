@extends('user.layout.app')

@section('content')
<div class="banner row no-margin" style="background-image: url('{{ asset('asset/img/banner-bg.jpg') }}');">
    <div class="banner-overlay"></div>
    <div class="container">
        <div class="col-md-8">
            <h2 class="banner-head"><span class="strong">Get there</span><br>Your day belongs to you</h2>
        </div>
        <div class="col-md-4">
            <div class="banner-form">
                <div class="row no-margin fields">
                    <div class="left">
                        <img src="{{ asset('asset/img/ride-form-icon.png') }}">
                    </div>
                    <div class="right">
                        <a href="{{url('login')}}">
                            <h3>Sign up to Ride</h3>
                            <h5>SIGN UP <i class="fa fa-chevron-right"></i></h5>
                        </a>
                    </div>
                </div>
                <div class="row no-margin fields">
                    <div class="left">
                        <img src="{{ asset('asset/img/ride-form-icon.png') }}">
                    </div>
                    <div class="right">
                        <a href="{{ url('/provider/register') }}">
                            <h3>Sign up to Drive</h3>
                            <h5>SIGN UP <i class="fa fa-chevron-right"></i></h5>
                        </a>
                    </div>
                </div>
                <p class="note-or">Or <a href="{{ url('/provider/login') }}">sign in</a> with your rider account.</p>
            </div>
        </div>
    </div>
</div>

<div class="row white-section no-margin">
    <div class="container">
        <div class="col-md-6 img-block text-center"> 
            <img src="{{ asset('asset/img/tap.png') }}">
        </div>
        <div class="col-md-6 content-block">
            <h2>Tap the app, get a ride</h2>
            <div class="title-divider"></div>
            <p>{{ Setting::get('site_title', 'Tranxit')  }} is the smartest way to get around. One tap and a car comes directly to you. Your driver knows exactly where to go. And you can pay with either cash or card.</p>
            <a class="content-more" href="#">MORE REASONS TO RIDE <i class="fa fa-chevron-right"></i></a>
        </div>
    </div>
</div>

<div class="row gray-section no-margin">
    <div class="container">                
        <div class="col-md-6 content-block">
            <h2>Ready anywhere, anytime</h2>
            <div class="title-divider"></div>
            <p>Daily commute. Errand across town. Early morning flight. Late night drinks. Wherever you’re headed, count on {{ Setting::get('site_title', 'Tranxit') }} for a ride—no reservations needed.</p>
            <a class="content-more" href="#">MORE REASONS TO RIDE <i class="fa fa-chevron-right"></i></a>
        </div>
        <div class="col-md-6 img-block text-center"> 
            <img src="{{ asset('asset/img/anywhere.png') }}">
        </div>
    </div>
</div>

<div class="row white-section no-margin">
    <div class="container">
        <div class="col-md-6 img-block text-center"> 
            <img src="{{ asset('asset/img/low-cost.png') }}">
        </div>
        <div class="col-md-6 content-block">
            <h2>Low-cost to luxury</h2>
            <div class="title-divider"></div>
            <p>You can always request everyday cars at everyday prices. But sometimes you need a bit more space. Or you want to go big on style. With {{ Setting::get('site_title', 'Tranxit') }}, the choice is yours.</p>
            <a class="content-more" href="#">MORE REASONS TO RIDE <i class="fa fa-chevron-right"></i></a>
        </div>
    </div>
</div>

<div class="row gray-section no-margin full-section">
    <div class="container">                
        <div class="col-md-6 content-block">
            <h3>Behind the Wheel</h3>
            <h2>They’re people like you, going your way</h2>
            <div class="title-divider"></div>
            <p>What makes the {{ Setting::get('site_title', 'Tranxit') }} experience truly great are the people behind the wheel. They are mothers and fathers. Students and teachers. Veterans. Neighbors. Friends. Our partners drive their own cars—on their own schedule—in cities big and small. Which is why more than one million people worldwide have signed up to drive.</p>
            <a class="content-more-btn" href="#">WHY DRIVE WITH {{ Setting::get('site_title', 'Tranxit')  }} <i class="fa fa-chevron-right"></i></a>
        </div>
        <div class="col-md-6 full-img text-center" style="background-image: url({{ asset('asset/img/behind-the-wheel.jpg') }});"> 
            <!-- <img src="img/anywhere.png"> -->
        </div>
    </div>
</div>

<div class="row white-section no-margin">
    <div class="container">
        <div class="col-md-6 img-block text-center"> 
            <img src="{{ asset('asset/img/low-cost.png') }}">
        </div>
        <div class="col-md-6 content-block">
            <h2>Helping Cities For the good of all</h2>
            <div class="title-divider"></div>
            <p>A city with {{ Setting::get('site_title', 'Tranxit') }} has more economic opportunities for residents, fewer drunk drivers on the streets, and better access to transportation for those without it.</p>
            <a class="content-more" href="#">OUR LOCAL IMPACT <i class="fa fa-chevron-right"></i></a>
        </div>
    </div>
</div>

<div class="row gray-section no-margin">
    <div class="container">
        <div class="col-md-6 content-block">
            <h2>Safety Putting people first</h2>
            <div class="title-divider"></div>
            <p>Whether riding in the backseat or driving up front, every part of the {{ Setting::get('site_title', 'Tranxit') }} experience has been designed around your safety and security.</p>
            <a class="content-more" href="#">HOW WE KEEP YOU SAFE <i class="fa fa-chevron-right"></i></a>
        </div>
        <div class="col-md-6 img-block text-center"> 
            <img src="{{ asset('asset/img/seat-belt.jpg') }}">
        </div>
    </div>
</div>

<div class="row find-city no-margin">
    <div class="container">
        <h2>{{ Setting::get('site_title','Tranxit') }} is in Chennai</h2>
        <form>
            <div class="input-group find-form">
                <input type="text" class="form-control" placeholder="Search" >
                <span class="input-group-addon">
                    <button type="submit">
                        <i class="fa fa-arrow-right"></i>
                    </button>  
                </span>
            </div>
        </form>
    </div>
</div>

<div class="footer-city row no-margin" style="background-image: url({{ asset('asset/img/footer-city.png') }});"></div>
@endsection