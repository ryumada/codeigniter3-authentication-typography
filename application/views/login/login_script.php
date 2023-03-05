<!-- pristinejs form validator -->
<!-- <script src="../../../assets/pristinejs-validator/pristine.min.js" type="text/javascript"></script> -->
<script src="<?= base_url() ?>assets/pristinejs-validator/pristine.min.js" type="text/javascript"></script>
<script>
	// pristinejs config file
	const validatorConfig = {
		// class of the parent element where the error/success class is added
		classTo: 'form-control',
		errorClass: 'is-invalid',
		successClass: 'is-valid',
		// class of the parent element where error text element is appended
		errorTextParent: 'form-floating',
		// type of element to create for the error text
		errorTextTag: 'div',
		// class of the error text element
		errorTextClass: 'invalid-feedback'
	}
</script>
<script>
	const formElement = document.getElementById('loginForm');
	const pristineValidator = new Pristine(formElement, validatorConfig);

	formElement.addEventListener('submit', (e) => {
		e.preventDefault();

		if (pristineValidator.validate()) {
			const formData = new FormData(e.target);
			// view data of formData
			for (const [key, value] of formData.entries()) {
				console.log(`${key}: ${value}`);
			}

			// const xhttp = new XMLHttpRequest();
			// xhttp.onreadystatechange = () => {
			// 	document.querySelector('main').innerHTML = xhttp.response;
			// }
			// xhttp.open("POST", "<?= base_url() ?>login/do_login", true);
			// xhttp.setRequestHeader("Http-X-Is-Ajax", "true");
			// xhttp.send(formData);

			formElement.submit();
		}
	});
</script>
