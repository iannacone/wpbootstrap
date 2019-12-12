<?php
/**
 * Displays footer widget for the site info if assigned
 *
 * @package wpbootstrap
 */


$current = 'bs-footer';
if (is_active_sidebar($current)) {
	?>
	<div class="site-info">
		<?php dynamic_sidebar($current); ?>
	</div>
	<?php
}
