<?php
/**
 * Displays header site branding
 *
 * @package wpbootstrap
 */

?>
<div class="site-branding">
	<?php
	
	if (has_custom_logo()) {
		echo get_custom_logo();
	}
	else {
		
		$tag = (is_front_page() && is_home() ? 'h1' : 'p');
		?>
		<<?php echo $tag; ?> class="site-title">
			<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
				<?php bloginfo('name'); ?>
			</a>
		</<?php echo $tag; ?>>
		<?php
		$description = get_bloginfo('description', 'display');
		if ($description || is_customize_preview()) {
			?>
			<p class="site-description"><?php echo $description; ?></p>
			<?php
		}
		
	}
	
	?>
</div>