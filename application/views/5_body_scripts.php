<script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script>
	const darkModeSwitch = document.getElementById("darkModeSwitch");
	darkModeSwitch.addEventListener("input", () => {
		if (darkModeSwitch.checked === true) {
			document.documentElement.setAttribute("data-bs-theme", "dark");
		} else {
			document.documentElement.setAttribute("data-bs-theme", "light");
		}
	})
</script>
