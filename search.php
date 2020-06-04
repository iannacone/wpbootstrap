<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package wpbootstrap
 */

$wpbs = [
	'template' => 'archive',
	'sidebar' => 'bs-side',
	'title' => sprintf(esc_html__('Search Results for: %s', I18N_TEXTDOMAIN), '<span>' . get_search_query() . '</span>'),
];
require(WPBOOTSTRAP_ABS . '/layout.php');
