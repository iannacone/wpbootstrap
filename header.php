<?php ob_start(); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
	<head <?php do_action('add_head_attributes'); ?>>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php /*
		<title>
			<?php
				$info = get_bloginfo('description', 'display');
				$name = get_bloginfo('name', 'display');
				echo $name . ($info == '' ? '' : ' - ' . $info);
			?>
		</title>
		*/ ?>
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
		<div id="bs-main-wrapper" class="flex">
			<header id="menu-header">
				<nav id="bs-main-menu" class="navbar navbar-default navbar-fixed-top" role="navigation"  data-spy="affix" data-offset-top="50">
					<?php /* <div class="container-fluid"> */ ?>
					<div class="container">
						<div class="navbar-header">
							<?php /*  mobile  */ ?>
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<?php /* <i class="fa fa-bars" title="<?php _e('Toggle navigation'); ?>" aria-label="<?php _e('Toggle navigation'); ?>"></i> */ ?>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<?php if (function_exists('the_custom_logo')) the_custom_logo(); ?>
						</div>
						<div id="bs-navbar-collapse" class="collapse navbar-collapse" aria-expanded="true">
							<?php /* main nav menu */ ?>
							<?php wp_nav_menu(array('theme_location' => 'main-header-menu', 'container' => false, 'menu_class' => 'main-header-menu nav navbar-nav', 'walker' => new wp_bootstrap_navwalker)); ?>
						</div>
					</div>
				</nav>
				<div id="menu-replacement"></div>
			</header>
			<?php /* <div id="bs-content" class="container"> */ ?>
			<div id="bs-content" class="container-fluid">
				<?php the_custom_header_markup(); ?>