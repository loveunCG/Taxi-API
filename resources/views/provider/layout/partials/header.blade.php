<header>
    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                    <span class="hamb-top"></span>
                    <span class="hamb-middle"></span>
                    <span class="hamb-bottom"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/provider') }}"><img src="{{ Setting::get('site_logo', asset('logo-black.png')) }}"></a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ url('help') }}">Help</a></li>
                    <li class="dropdown mega-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::guard('provider')->user()->first_name }} {{ Auth::guard('provider')->user()->last_name }}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu mega-dropdown-menu">
                            <li class="row no-margin">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center">
                                    <a href="#" class="new-pro-img bg-img" style="background-image: url({{ Auth::guard('provider')->user()->avatar ? asset('storage/'.Auth::guard('provider')->user()->avatar) : asset('asset/img/provider.jpg') }});">
                                    </a>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <h6 class="new-pro-name">
                                        {{ Auth::guard('provider')->user()->first_name }} {{ Auth::guard('provider')->user()->last_name }}
                                    </h6>
                                    <div class="rating-outer new-pro-rating">
                                        <input type="hidden" class="rating"/ value="{{ Auth::guard('provider')->user()->rating }}" readonly>
                                    </div>

                                    <a href="{{ route('provider.profile.index') }}" class="new-pro-link">My Profile</a>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('provider.change.password')}}">Change Password</a></li>
                            <li>
                                <a href="{{ url('/provider/logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ url('/provider/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>