<div class="row">
	<div class="col-md-7 col-lg-5 mt-5 mx-auto">
		<form id="loginForm" class="needs-validation" method="post" action="<?= base_url('login'); ?>" novalidate>
			<!-- <img class="mb-4" src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
			<h1 class="h3 mb-3 fw-normal text-center">Please sign in</h1>
			<?php if($this->session->flashdata('message')): ?>
				<div class="card bg-danger text-white">
					<div class="card-body p-1">
						<div class="card-text"><?= $this->session->flashdata('message'); ?></div>
					</div>
				</div>
			<?php endif; ?>
			<div class="form-floating">
				<input name="email" type="email" class="form-control" id="email" placeholder="name@example.com" data-pristine-required-message="Please type your email." required value="<?= (isset($email)) ? $email : "" ?>">
				<label for="email">Email address</label>
			</div>
			<div class="form-floating">
				<input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required minlength="8" data-pristine-required-message="Password is needed?!" data-pristine-minlength-message="Password must contains at least 8 characters." value="<?= (isset($password)) ? $password : "" ?>">
				<label for="floatingPassword">Password</label>
			</div>

			<div class="checkbox mt-1 mb-3">
				<label>
					<div class="form-floating">
						<input name="remember_me" type="checkbox" required <?= (isset($remember_me)) ? "checked" : "" ?>>
					</div>
					Remember me
				</label>
			</div>
			<button id="loginFormSubmitButton" class="w-100 btn btn-lg btn-primary mb-5" type="submit">Sign in</button>
		</form>
	</div>
</div>
