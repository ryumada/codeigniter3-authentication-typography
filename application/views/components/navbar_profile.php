<ul class="navbar-nav">
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
			<img src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Bootstrap" width="30" height="24"><span class="ms-1">Hi, <?= $email; ?></span>
		</a>
		<ul class="dropdown-menu end-0 overflow-hidden pb-0">
			<li><a class="dropdown-item" href="#">Action</a></li>
			<li><a class="dropdown-item" href="#">Another action</a></li>
			<li>
				<hr class="dropdown-divider mb-0">
			</li>
			<li><a id="logoutButton" class="dropdown-item bg-danger text-light py-2" href="<?= base_url('logout'); ?>">Logout</a></li>
		</ul>
	</li>
</ul>

<script>
	const logoutButton = document.getElementById('logoutButton');
	logoutButton.addEventListener('mouseover', event => {
		event.target.style.cssText = 'background-color: #FF3545 !important';
	});
	logoutButton.addEventListener('mouseout', event => {
		event.target.style.removeProperty('background-color');
	});
</script>
