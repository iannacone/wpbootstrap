<?php
/**
 * Displays top navigation
 *
 * @package wp-bootstrap
 */

if (has_nav_menu('primary-menu')) {
	?>
	<nav id="site-navigation" class="main-navigation navbar navbar-expand-md navbar-light" role="navigation" aria-label="<?php esc_attr_e('Top Menu'); ?>">
		<div class="container">
			
			<?php get_template_part('template-parts/header/site-branding'); ?>
			
			<?php /*  mobile  */ ?>
			<button type="button" class="menu-toggle navbar-toggler collapsed" data-toggle="collapse" data-target="#primary-menu" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation'); ?>">
				<span class="sr-only"><?php esc_html_e('Toggle navigation'); ?></span>
				<span class="navbar-toggler-icon"></span>
				<?php /* <span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span> */ ?>
			</button>
			
			<div id="primary-menu" class="collapse navbar-collapse">
				<?php wp_nav_menu([
					'theme_location' => 'primary-menu',
					'container' => false,
					'menu_class' => 'nav navbar-nav',
					'walker' => new \WP_Bootstrap_Navwalker(),
				]); ?>
			</div>
			
		</div>
	</nav>
	<?php
}