<?php
/**
 * Displays footer widget for the site info if assigned
 *
 * @package wpbootstrap
 */

?>
<div class="site-info">
	<?php
	$current = 'bs-footer';
	if (is_active_sidebar($current)) {
		dynamic_sidebar($current);
	}
	?>
</div>