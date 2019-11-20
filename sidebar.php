<?php
/**
* The sidebar containing the main widget area
*
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package wpbootstrap
*/

global $wpbs;

if ($wpbs['has_sidebar']) {
	?>
	<aside id="<?php echo esc_attr($wpbs['sidebar']); ?>" class="secondary widget-area col-xs-12 col-sm-4 col-md-3" role="complementary" aria-label="<?php esc_attr_e('Sidebar'); ?>">
		<?php dynamic_sidebar($wpbs['sidebar']); ?>
	</aside>
<?php } ?>
