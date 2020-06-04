<?php

/**
 * The template for displaying category pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wpbootstrap
 */

$wpbs = [
	'template' => 'category',
	'sidebar' => 'bs-side',
	'title' => single_cat_title('', false),
	'description' => category_description(),
	'display_pagination' => true,
];
require(WPBOOTSTRAP_ABS . '/layout.php');
