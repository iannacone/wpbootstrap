<?php
/**
 * Displays footer widgets if assigned
 *
 * @package wpbootstrap
 */

?>
<aside class="widget-area row" role="complementary" aria-label="<?php esc_attr_e('Footer'); ?>">
	<?php
	for ($c = 1; $c <= WPBOOTSTRAP_FOOTER_COLUMNS; $c++) {
		$current = 'bs-footer-' . $c;
		if (is_active_sidebar($current)) {
			?>
			<div class="col">
				<?php dynamic_sidebar($current); ?>
			</div>
			<?php
		}
	}
	?>
</aside>
