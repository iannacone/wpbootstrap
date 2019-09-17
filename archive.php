<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wpbootstrap
 */

$wpbs = [
	'template' => 'archive',
	'sidebar' => 'bs-widget-side',
	'title' => get_the_archive_title(),
	'description' => get_the_archive_description(),
	'display_pagination' => true,
];
require(WPBOOTSTRAP_ABS . '/layout.php');