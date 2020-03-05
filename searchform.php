<?php
/**
 * Template for displaying search forms in Twenty Seventeen
 *
 * @package wpbootstrap
 */
 
 /* http://adrianroselli.com/2015/08/where-to-put-your-search-role.html */



$unique_id = esc_attr(uniqid('search-form-'));

?>
<div class="search-form" role="search">
	<form method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
		<label for="<?php echo $unique_id; ?>">
			<span class="screen-reader-text"><?php echo _x('Search for:', 'label') ?></span>
			<input type="search" id="<?php echo $unique_id; ?>" class="search-field" placeholder="<?php echo esc_attr_x('Search …', 'placeholder') ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x('Search for:', 'label') ?>" />
		</label>
		<button type="submit" class="search-submit">
			<span class="screen-reader-text"><?php esc_html_e('Search', 'submit button') ?></span>
			<i class="fas fa-search">&nbsp;</i>
		</button>
	</form>
</div>