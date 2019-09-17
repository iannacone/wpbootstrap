<?php
/**
 * Displays top navigation
 *
 * @package wp-bootstrap
 */

if (has_nav_menu('primary-menu')) {
?>
<nav id="site-navigation" class="main-navigation navbar navbar-default" role="navigation" aria-label="<?php esc_attr_e('Top Menu'); ?>">
	<div class="container">
		<div class="navbar-header">
			<?php /*  mobile  */ ?>
			<button type="button" class="menu-toggle navbar-toggle collapsed" data-toggle="collapse" data-target="#primary-menu" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation'); ?>">
				<span class="sr-only"><?php esc_html_e('Toggle navigation'); ?></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php /*
			
			if (has_custom_logo() || is_customize_preview()) {
				echo get_custom_logo();
			}
			else {
				?>
				<a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
				<?php
			}
			
			*/ ?>
		</div>
		<div id="primary-menu" class="collapse navbar-collapse">
			<?php wp_nav_menu(array(
				// 'menu_id' => 'primary-menu',
				'theme_location' => 'primary-menu',
				'container' => false,
				'menu_class' => 'nav navbar-nav',
				'walker' => new \WP_Bootstrap_Navwalker(),
			)); ?>
		</div>
	</div>
</nav>
<div id="primary-menu-replacement"></div>
<?php
}