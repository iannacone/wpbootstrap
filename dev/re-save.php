<?php

$page_ids = [
	693,
	695,
	697,
	699,
	701,
	703,
	705,
	707,
];
$query = new WP_Query([
	'post_type' => 'any',
	'posts_per_page' => -1,
	'post_status' => 'any',
	'post__in' => $page_ids,
]);

$pages = $query->get_posts();

/*
foreach ($pages as $page) {
	$mem = $page->ping_status;
	$page->ping_status = ($mem === 'open' ? 'closed' : 'open');
	wp_update_post($page);
	$page->ping_status = $mem;
	wp_update_post($page);
}
*/

foreach ($pages as $page) {
	$mem = $page->post_excerpt;
	$page->post_excerpt = '';
	wp_update_post($page);
}

wp_reset_query();
wp_reset_postdata();

// die('clean');

?>