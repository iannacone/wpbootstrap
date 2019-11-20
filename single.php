<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package wpbootstrap
 */

$wpbs = [
	'template' => 'singular',
	'sidebar' => 'bs-side',
	'header_pic' => get_post_thumbnail_id(),
];
require(WPBOOTSTRAP_ABS . '/layout.php');