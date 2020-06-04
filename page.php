<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wpbootstrap
 */

$wpbs = [
	'template' => 'singular',
	'sidebar' => 'bs-side',
	'header_pic' => get_post_thumbnail_id(),
];
require(WPBOOTSTRAP_ABS . '/layout.php');
