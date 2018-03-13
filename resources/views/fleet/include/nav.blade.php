<div class="site-sidebar">
	<div class="custom-scroll custom-scroll-light">
		<ul class="sidebar-menu">
			<li class="menu-title">Fleet Dashboard</li>
			<li>
				<a href="{{ route('fleet.dashboard') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-anchor"></i></span>
					<span class="s-text">Dashboard</span>
				</a>
			</li>
			
			<li class="menu-title">Members</li>
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="ti-car"></i></span>
					<span class="s-text">Providers</span>
				</a>
				<ul>
					<li><a href="{{ route('fleet.provider.index') }}">List Providers</a></li>
					<li><a href="{{ route('fleet.provider.create') }}">Add New Provider</a></li>
				</ul>
			</li>
			<li class="menu-title">Details</li>
			<li>
				<a href="{{ route('fleet.map.index') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-map-alt"></i></span>
					<span class="s-text">Map</span>
				</a>
			</li>
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="ti-view-grid"></i></span>
					<span class="s-text">Ratings &amp; Reviews</span>
				</a>
				<ul>
					<li><a href="{{ route('fleet.provider.review') }}">Provider Ratings</a></li>
				</ul>
			</li>
			<li class="menu-title">Requests</li>
			<li>
				<a href="{{ route('fleet.requests.index') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-infinite"></i></span>
					<span class="s-text">Request History</span>
				</a>
			</li>
			<li>
				<a href="{{ route('fleet.requests.scheduled') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-palette"></i></span>
					<span class="s-text">Scheduled Rides</span>
				</a>
			</li>
			
			<li class="menu-title">Account</li>
			<li>
				<a href="{{ route('fleet.profile') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-user"></i></span>
					<span class="s-text">Account Settings</span>
				</a>
			</li>
			<li>
				<a href="{{ route('fleet.password') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-exchange-vertical"></i></span>
					<span class="s-text">Change Password</span>
				</a>
			</li>
			<li class="compact-hide">
				<a href="{{ url('/fleet/logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
					<span class="s-icon"><i class="ti-power-off"></i></span>
					<span class="s-text">Logout</span>
                </a>

                <form id="logout-form" action="{{ url('/fleet/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
			</li>
			
		</ul>
	</div>
</div>