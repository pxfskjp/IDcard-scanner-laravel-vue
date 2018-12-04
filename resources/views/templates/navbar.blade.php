<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top d-print-none">
	<a class="navbar-brand" href="/">Scanner</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	 <span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarNav">
		@if (Auth::check())
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/admin/reports') }}">Reports</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/admin/events') }}">Events</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/admin/members') }}">Members</a>
				</li>
			</ul>
			<ul class="nav navbar-nav ml-auto" >
				<li class="nav-item"> 
					<a class="nav-link" href="{{ url('/settings') }}">Settings</a>
				</li>
				<li class="nav-item"> 
					<a class="nav-link" href="{{ url('/logout') }}">Logout</a>
				</li>
			</ul>
		@else
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="{{ url('/login') }}">Admin</a>
				</li>
			</ul>
		@endif
	</div>
</nav>