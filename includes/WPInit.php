<?php





function register_custom_post_types() {
	register_post_type('profile', [
		'labels' => [
			'name' => __('Profile'),
			'singular_name' => __('Profile'),
		],
		'public' => true,
		'has_archive' => true,
		'can_export' => true,
		'menu_position' => 6,
		'menu_icon' => 'dashicons-id',
		'supports' => [
			'title',
			'editor',
			'thumbnail',
			'revisions',
			'custom-fields',
			'page-attributes',
		],
		'taxonomies' => [
			'category',
		],
		'show_in_rest' => true,
	]);
}
add_action('init', 'register_custom_post_types');