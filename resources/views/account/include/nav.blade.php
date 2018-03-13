<div class="site-sidebar">
	<div class="custom-scroll custom-scroll-light">
		<ul class="sidebar-menu">
			<li class="menu-title">Account Dashboard</li>
			<li>
				<a href="{{ route('account.dashboard') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-anchor"></i></span>
					<span class="s-text">Dashboard</span>
				</a>
			</li>
			<li class="menu-title">Accounts Statements</li>
			<li>
				<a href="{{ route('account.ride.statement') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-target"></i></span>
					<span class="s-text">Overall Ride Statments</span>
				</a>
			</li>
			<li>
				<a href="{{ route('account.ride.statement.provider') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-target"></i></span>
					<span class="s-text">Provider Statement</span>
				</a>
			</li>
			<li>
				<a href="{{ route('account.ride.statement.today') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-target"></i></span>
					<span class="s-text">Daily Statement</span>
				</a>
			</li>
			<li>
				<a href="{{ route('account.ride.statement.monthly') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-target"></i></span>
					<span class="s-text">Monthly Statement</span>
				</a>
			</li>
			<li>
				<a href="{{ route('account.ride.statement.yearly') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-target"></i></span>
					<span class="s-text">Yearly Statement</span>
				</a>
			</li>
			<li class="menu-title">Account</li>
			<li>
				<a href="{{ route('account.profile') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-user"></i></span>
					<span class="s-text">Account Settings</span>
				</a>
			</li>
			<li>
				<a href="{{ route('account.password') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-exchange-vertical"></i></span>
					<span class="s-text">Change Password</span>
				</a>
			</li>
			<li class="compact-hide">
				<a href="{{ url('/account/logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
					<span class="s-icon"><i class="ti-power-off"></i></span>
					<span class="s-text">Logout</span>
                </a>

                <form id="logout-form" action="{{ url('/account/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
			</li>
			
		</ul>
	</div>
</div>