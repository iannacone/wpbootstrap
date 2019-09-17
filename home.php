<?php
ob_start();
get_header();
?>
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-title"><?php the_archive_title(); ?></h1>
	</div>
</div>
<div class="row">
	<main class="col-xs-12 col-sm-8 col-md-9" role="main">
		<?php
		if (have_posts()) {
			?>
			<div class="row">
				<?php
				$cnt = 0;
				while (have_posts()) {
					the_post();
					?>
					<article class="col-xs-12 post archive-post">
						<header class="entry-header">
							<h3 class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
									<?php the_title(); ?>
								</a>
							</h3>
						</header>
						<div class="entry-content">
							<?php the_excerpt(); ?>
						</div>
					</article>
				<?php } ?>
			</div>
			<?php wpbs_pagenavi(); ?>
			<div class="row">
				<div class="col-xs-12 taxonomy-description">
					<?php the_archive_description(); ?>
				</div>
			</div>
			<?php
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