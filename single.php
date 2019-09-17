<?php
ob_start();
get_header();
?>
<div class="row">
	<main class="col-xs-12 col-sm-8 col-md-9" role="main">
		<?php
		if (have_posts()) {
			while (have_posts()) {
				the_post();
				?>
				<article class="row post hentry">
					<div class="col-xs-12">
						<header class="entry-header">
							<h1 class="entry-title">
								<?php the_title(); ?>
							</h1>
						</header>
						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					</div>
				</article>
				<?php
				if (comments_open() || get_comments_number())
					comments_template();
				else if (is_user_logged_in())
					do_action('comment_form_after_fields');
			}
		} else
			page_not_found();
		?>
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