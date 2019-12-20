<?php
/**
 * Displays the custom header media
 *
 * @package wpbootstrap
 */


$custom_header_markup = get_custom_header_markup();

if ($custom_header_markup) {
	?>
	<div class="custom-header-media text-center">
		<?php
		echo $custom_header_markup;
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
	<?php
}