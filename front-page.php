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
				<article class="col-xs-12 post archive-post">
					<header class="entry-header">
						<h3 class="entry-title">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
						</h3>
					</header>
					<div class="entry-content">
						<?php the_excerpt(); ?>
					</div>
				</article>
				<?php
			}
			wpbs_pagenavi();
		} else {
		?>
			<p><?php _e('Sorry, this page does not exist.'); ?></p>
		<?php } ?>
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