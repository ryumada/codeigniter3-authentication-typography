<script src="<?= base_url('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('node_modules/sweetalert2/dist/sweetalert2.all.min.js'); ?>"></script>

<script src="<?= base_url('assets/router/main-router.js'); ?>"></script>

<script>
	/**
	 * Dark Mode switcher
	 */
	const darkModeSwitch = document.getElementById("darkModeSwitch");
	darkModeSwitch.addEventListener("input", () => {
		if (darkModeSwitch.checked) {
			document.documentElement.setAttribute("data-bs-theme", "dark");
		} else {
			document.documentElement.setAttribute("data-bs-theme", "light");
		}
	});

	/**
	 * Create swal toaster
	 */
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 3000,
		timerProgressBar: true,
		didOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	});

	/**
	 * Show a Toast Notification using sweetalert2.
	 * 
	 * @param {String} icon		The icon used for sweetalert2 (`"warning"`, `"error"`, `"success"`, `"info"`, and `"question"`)
	 * @param {String} title	The title string for notification Toast.
	 * @param {String} msg		The message string that you want to show to user.
	 * @param {*} sweetalertToastMixin The Mixin from sweet alert, example:
	 * ```
	 * const Toast = Swal.mixin({
	 * 	toast: true,
	 * 	position: 'top-end',
	 * 	showConfirmButton: false,
	 * 	timer: 3000,
	 * 	timerProgressBar: true,
	 * 	didOpen: (toast) => {
	 * 		toast.addEventListener('mouseenter', Swal.stopTimer)
	 * 		toast.addEventListener('mouseleave', Swal.resumeTimer)
	 * 	}
	 * })
	 * ```
	 */
	const showToast = ({
		icon = 'error',
		title = 'Error?!',
		msg = ""
	}) => {
		try {
			Toast.fire({
				icon: icon,
				title: title,
				text: msg
			});
		} catch (error) {
			alert(msg);
		}
	}
</script>
