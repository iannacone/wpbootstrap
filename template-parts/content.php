<?php
/**
 * Template part for displaying multiple posts/pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wpbootstrap
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
		<div class="col-xs-12">
			<header class="entry-header">
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php esc_attr(get_the_title()); ?>">
						<?php the_title(); ?>
					</a>
				</h2>
			</header>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div>
		</div>
	</div>
</article>
