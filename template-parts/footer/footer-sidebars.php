<?php

/**
 * Displays footer widgets if assigned
 *
 * @package wpbootstrap
 */

$actives = [];
for ($c = 1; $c <= WPBOOTSTRAP_FOOTER_COLUMNS; $c++) {
	$current = 'bs-footer-' . $c;
	if (is_active_sidebar($current)) {
		$actives[] = $current;
	}
}

if (count($actives) > 0) {
?>
	<aside class="widget-area row" role="complementary" aria-label="<?php esc_attr_e('Footer', I18N_TEXTDOMAIN); ?>">
		<?php
		foreach ($actives as $active) {
		?>
			<div class="col">
				<?php dynamic_sidebar($active); ?>
			</div>
		<?php } ?>
	</aside>
<?php
}
