<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
    <ul class="nav sidebar-nav">
        <li>
            <a href="{{ route('provider.earnings') }}">Patner Earnings</a>
        </li>
        <!-- <li>
            <a href="#">Invite</a>
        </li> -->
        <li>
            <a href="{{ route('provider.profile.index') }}">Profile</a>
        </li>
        <!-- <li>
            <a href="#">Help</a>
        </li> -->
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
</nav>