<?php

/**
 * Template part for displaying singular posts/pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wpbootstrap
 */


global $wpbs;

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ($wpbs['display_title'] !== false) { ?>
		<header class="entry-header">
			<h1 class="entry-title">
				<?php the_title(); ?>
			</h1>
		</header>
	<?php } ?>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>

	<?php if (get_edit_post_link()) { ?>
		<footer class="entry-footer">
			<span class="edit-link">
				<?php edit_post_link(__('Edit', I18N_TEXTDOMAIN)); ?>
			</span>
		</footer>
	<?php } ?>
</article>
<?php
if (comments_open() || get_comments_number())
	comments_template();
else if (is_user_logged_in())
	do_action('comment_form_after_fields');
