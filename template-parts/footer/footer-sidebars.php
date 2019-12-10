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
		if (is_active_sidebar('bs-footer-' . $c)) {
			?>
			<div class="col">
				<?php dynamic_sidebar($active); ?>
			</div>
			<?php
		}
	}
	?>
</aside>
