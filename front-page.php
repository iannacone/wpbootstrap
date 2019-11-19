<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wpbootstrap
 */

$wpbs = [
	'template' => 'singular',
	'sidebar' => 'side',
	'header_pic' => get_post_thumbnail_id(),
	'display_title' => false,
];
require(WPBOOTSTRAP_ABS . '/layout.php');