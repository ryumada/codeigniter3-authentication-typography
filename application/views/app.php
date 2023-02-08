<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title><?= $pageinfo['title'] ?></title>

	<link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
	<link rel="stylesheet" media="screen, print" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css');?>">
</head>
<body>
	<nav class="navbar navbar-expand-lg bg-body-tertiary">
		<div class="container-fluid">
			<a class="navbar-brand" href="#">Navbar</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="#">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Link</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Dropdown
						</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="#">Action</a></li>
							<li><a class="dropdown-item" href="#">Another action</a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="#">Something else here</a></li>
						</ul>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled">Disabled</a>
					</li>
				</ul>
				<form class="d-flex">
					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" role="switch" id="darkModeSwitch">
					</div>
				</form>
			</div>
		</div>
	</nav>

	<main class="container-fluid">
		<?php $this->load->view($load_view) ?>
	</main>

	<footer class="footer mt-auto py-1">
		<div class="container-fluid px-2 text-center">
			<span class="text-muted">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></span>
		</div>
	</footer>
	<script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js');?>""></script>
	<script>
		const darkModeSwitch = document.getElementById("darkModeSwitch");
		darkModeSwitch.addEventListener("input", () => {
			if (darkModeSwitch.checked === true)
			{
				document.documentElement.setAttribute("data-bs-theme", "dark");
			} else {
				document.documentElement.setAttribute("data-bs-theme", "light");
			}
		})
	</script>
</body>
</html>
