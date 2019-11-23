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

$column_num = count($actives);

if ($column_num) {
	
	$columns_class = 'col-xs-12';
	
	for ($c = WPBOOTSTRAP_FOOTER_COLUMNS; $c > 1; $c--)
		if ($column_num % $c == 0)
			switch ($c) {
				case 2:
					$columns_class .= ' col-sm-6';
					break;
				case 3:
					$columns_class .= ' col-md-4';
					break;
				case 4:
					$columns_class .= ' col-md-3';
					break;
				case 5:
					$columns_class .= ' col-md-20p'; // 20% is an additional class which bootstrap do not have (width: 20%)
					break;
				case 6:
					$columns_class .= ' col-lg-2';
					break;
				default:
					break;
			}
	
	?>
	<aside class="widget-area row variable-columns" role="complementary" aria-label="<?php esc_attr_e('Footer'); ?>">
		<?php foreach ($actives as $active) { ?>
			<div class="<?php echo $columns_class; ?>">
				<?php dynamic_sidebar($active); ?>
			</div>
		<?php } ?>
	</aside>
	
<?php } ?>