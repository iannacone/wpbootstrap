<?php
/**
 * Template part for displaying category page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wpbootstrap
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

        <?php if (has_post_thumbnail()) { ?>
            <div class="img-thumbnail rounded"><?php /* .img-* classes should refer to the <img> tag */ ?>
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <?php the_post_thumbnail(); ?>
                </a>
            </div>
        <?php } ?>
        
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
				<?php the_title(); ?>
			</a>
		</h2>

	</header>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>
</article>
