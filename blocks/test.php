<?php

function gutenberg_test_block() {
	
	wp_register_script('gutenberg-test', dirname(__FILE__) . '/test.js', array('wp-blocks', 'wp-element'));

	register_block_type('gutenberg-test/test', array(
		'editor_script' => 'gutenberg-test',
	));
	
}
add_action('init', 'gutenberg_test_block');
