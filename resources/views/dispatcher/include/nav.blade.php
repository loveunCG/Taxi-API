<div class="site-sidebar">
	<div class="custom-scroll custom-scroll-light">
		<ul class="sidebar-menu">
			<li class="menu-title">Dispatcher Dashboard</li>
			<li>
				<a href="{{ route('dispatcher.index') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-target"></i></span>
					<span class="s-text">Dispatcher Panel</span>
				</a>
			</li>
			
			<li class="menu-title">Account</li>
			<li>
				<a href="{{ route('dispatcher.profile') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-user"></i></span>
					<span class="s-text">Account Settings</span>
				</a>
			</li>
			<li>
				<a href="{{ route('dispatcher.password') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-exchange-vertical"></i></span>
					<span class="s-text">Change Password</span>
				</a>
			</li>
			<li class="compact-hide">
				<a href="{{ url('/dispatcher/logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
					<span class="s-icon"><i class="ti-power-off"></i></span>
					<span class="s-text">Logout</span>
                </a>

                <form id="logout-form" action="{{ url('/dispatcher/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
			</li>
			
		</ul>
	</div>
</div>