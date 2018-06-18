<div class="hidden-xs hidden-sm hidden-md col-sm-3 rightnav">
	<div>
		<div class="jumbotron" style="padding-bottom: 1rem; margin-bottom: 0;">
			<img src="{{ (Auth::user())->dp() }}" class="img-responsive dp">
			<h4 class="text-center">
				{{ (Auth::user())->name() }} | <a href="/auth/logout">Logout</a>
			</h4>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="mdi mdi-bell mdi-18px"></i> Notifications
			</div>
		</div>
		<div class="notification">
			No new notification.
		</div>
	</div>
</div>