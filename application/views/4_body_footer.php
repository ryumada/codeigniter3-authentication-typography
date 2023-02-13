<footer class="footer mt-auto py-1">
	<div class="container-fluid px-2 text-center">
		<span class="text-muted">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></span>
		<?php if (ENVIRONMENT === 'development') : ?>
			<p class="text-muted">Memory Consumption: {memory_usage}</p>
		<?php endif; ?>
	</div>
</footer>
