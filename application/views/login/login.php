<div class="row">
	<div class="col-md-7 col-lg-5 mt-5 mx-auto">
		<!-- action="<?= base_url('login'); ?>" -->
		<form id="loginForm" class="needs-validation" method="post" novalidate>
			<!-- <img class="mb-4" src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
			<h1 class="h3 mb-3 fw-normal text-center">Please sign in</h1>

			<div class="form-floating">
				<input name="email" type="email" class="form-control" id="email" placeholder="name@example.com" data-pristine-required-message="Please type your email." required>
				<label for="email">Email address</label>
			</div>
			<div class="form-floating">
				<input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required minlength="8" data-pristine-required-message="Password is needed?!" data-pristine-min-message="Password is needed and must contains at least 8 characters.">
				<label for="floatingPassword">Password</label>
			</div>

			<div class="checkbox mt-1 mb-3">
				<label>
					<div class="form-floating">
						<input name="remember-me" type="checkbox" required>
					</div>
					Remember me
				</label>
			</div>
			<button id="loginFormSubmitButton" class="w-100 btn btn-lg btn-primary mb-5" type="submit">Sign in</button>
		</form>
	</div>
</div>
