<?php
/**
 * Displays fixed bottom right widgets if assigned
 *
 * @package wpbootstrap
 */

if (is_active_sidebar('bs-fixed-bottom-right')) {
	?>
	<div id="bs-fixed-bottom-right">
		<?php dynamic_sidebar('bs-fixed-bottom-right'); ?>
	</div>
	<?php
}
