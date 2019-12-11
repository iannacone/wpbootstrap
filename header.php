<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wpbootstrap
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head <?php do_action('add_head_attributes'); ?>>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
		<?php wp_body_open(); ?>
		<div id="page" class="site">
			<a class="skip-link sr-only" href="#content"><?php _e('Skip to content'); ?></a>
			<header id="masthead" class="site-header text-center" role="banner">
				<?php
				get_template_part('template-parts/header/site-branding');
				get_template_part('template-parts/navigations/primary-menu');
				?>
			</header>
			<div id="content" class="site-content container-fluid">
				<?php get_template_part('template-parts/header/custom-header-media'); ?>