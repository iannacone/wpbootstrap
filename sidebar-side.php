<?php
/**
* The sidebar containing the main widget area
*
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package wpbootstrap
*/


?>
<aside id="bs-side-sidebar" class="secondary widget-area col-xs-12 col-sm-4 col-md-3" role="complementary" aria-label="<?php esc_attr_e('Sidebar'); ?>">
	<?php dynamic_sidebar('bs-widget-side'); ?>
</aside>