<?php
/**
 * Displays the custom header media
 *
 * @package wpbootstrap
 */

?>
<div class="custom-header-media text-center">
	<?php
	the_custom_header_markup();
	/*
	$description = get_bloginfo('description', 'display');
	if ($description || is_customize_preview()) {
		?>
		<p class="site-description"><?php echo $description; ?></p>
		<?php
	}
	*/
	?>
</div>