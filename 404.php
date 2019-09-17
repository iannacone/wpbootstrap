<?php
ob_start();
get_header();
?>
<div class="row">
	<main class="col-xs-12 col-sm-8 col-md-9" role="main">
		<?php page_not_found(); ?>
	</main>
	<div class="col-xs-12 col-sm-4 col-md-3">
		<div id="bs-side-sidebar" class="secondary">
			<div id="bs-widget-side">
				<?php sidebar('bs-widget-side'); ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>