<?php

/**
 * The front posts page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wpbootstrap
 */

$wpbs = [
	'sidebar' => 'bs-side',
	'header_pic' => get_post_thumbnail_id(),
	'title' => single_post_title('', false),
	'display_pagination' => true,
];
require(WPBOOTSTRAP_ABS . '/layout.php');
