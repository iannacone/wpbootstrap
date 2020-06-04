<?php

/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wpbootstrap
 */

?>
<section class="no-results not-found">

	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e('Nothing Found', I18N_TEXTDOMAIN); ?></h1>
	</header>

	<div class="page-content">
		<p><?php esc_html_e((is_search()
				? 'Sorry, but nothing matched your search terms. Please try again with some different keywords.'
				: 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.'), I18N_TEXTDOMAIN); ?></p>
		<?php get_search_form(); ?>
	</div>

</section>