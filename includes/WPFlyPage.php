<?php

/**
 * WPFlyPage
 * @author Ohad Raz and Simone Iannacone
 * @since 0.1
 * Class to create pages "On the FLY"
 * Usage: 
 *   $args = array(
 *       'slug' => 'page_slug',
 *       'post_title' => 'Page Title',
 *       'post_content' => 'This is the page content'
 *   );
 *   new WPFlyPage($args);
 * 
 * https://coderwall.com/p/fwea7g
 * https://barn2.co.uk/create-fake-wordpress-post-fly/
 * https://github.com/WPBP/FakePage/blob/master/fake-page.php
 */
class WPFlyPage
{


	/**
	 * @var array 
	 */
	private $args = array();



	/**
	 * __construct
	 * @param array $arg post to create on the fly
	 */
	function __construct($args)
	{
		$this->args = (array) $args;

		if (isset($this->args['slug']) && !empty($this->args['slug'])) {

			add_filter('pre_get_posts', array($this, 'enable_filters'), 10, 1);
			add_filter('the_posts', array($this, 'fly_page'), 10, 2);
		} else if (defined('WP_DEBUG') && \WP_DEBUG) {
			throw new Exception('Class WPFlyPage: you must set a post slug.');
		}
	}



	/**
	 * fly_page 
	 * the Money function that catches the request and returns the page as if it was retrieved from the database
	 * @param array $posts 
	 * @return array 
	 */
	public function enable_filters($wp_query)
	{
		$wp_query->query_vars['suppress_filters'] = false;

		return $wp_query;
	}


	/**
	 * fly_page 
	 * the Money function that catches the request and returns the page as if it was retrieved from the database
	 * @param array $posts 
	 * @return array 
	 */
	public function fly_page($posts, $wp_query)
	{
		// var_dump($wp_query);
		// die();
		global $wp, $post;

		$page_slug = $this->args['slug'];

		//check if user is requesting our page before display the 404 page
		if (count($posts) == 0 && (strtolower($wp->request) == $page_slug || (isset($wp->query_vars['page_id']) && $wp->query_vars['page_id'] == $page_slug))) {

			$now = current_time('mysql');
			$now_gmt = current_time('mysql', 1);
			$guid = get_bloginfo('wpurl' . '/' . $page_slug);

			$default = array(
				'post_author' => 1,
				'post_date' => $now,
				'post_date_gmt' => $now_gmt,
				'post_content' => '',
				'post_title' => '',
				'excerpt' => '',
				'post_status' => 'publish',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_password' => '',
				'post_name' => $page_slug,
				'to_ping' => '',
				'pinged' => '',
				'post_modified' => $now,
				'post_modified_gmt' => $now_gmt,
				'post_content_filtered' => '',
				'post_parent' => 0,
				'guid' => $guid,
				'menu_order' => 0,
				'post_type' => 'page',
				'post_mime_type' => '',
				'comment_count' => 0,

				'menu_item_parent' => 0,
			);

			/* unnecessary
			$this->args['ancestors'] = (isset($this->args['post_parent']) && !empty($this->args['post_parent'])
				? array_filter(array_merge(get_post_ancestors($this->args['post_parent']), array($this->args['post_parent'])))
				: array());
				
			$this->args['description'] = $this->args['excerpt'];
			
			$this->args['url'] = $this->args['guid'];
			
			$this->args['menu_item_parent'] = 0; // too much work for calculate it
			*/

			$args = wp_parse_args($this->args, $default);
			// musts
			$args['ID'] = -1;
			$args['filter'] = 'raw';

			$wp_query->queried_object = $wp_query->post = $post = new WP_Post(json_decode(json_encode($args), false));
			$wp_query->posts = $posts = array($post);

			$wp_query->current_post = $wp_query->queried_object_id = $post->ID;

			$wp_query->comment_count = $post->comment_count;
			$wp_query->current_comment = null;

			unset($wp_query->query['error']);
			$wp_query->query_vars['error'] = '';

			$wp_query->max_num_pages = $wp_query->post_count = $wp_query->found_posts = 1;

			$wp_query->is_page = true;
			$wp_query->is_singular = true;
			$wp_query->is_single = false;
			$wp_query->is_attachment = false;
			$wp_query->is_archive = false;
			$wp_query->is_category = false;
			$wp_query->is_tag = false;
			$wp_query->is_tax = false;
			$wp_query->is_author = false;
			$wp_query->is_date = false;
			$wp_query->is_year = false;
			$wp_query->is_month = false;
			$wp_query->is_day = false;
			$wp_query->is_time = false;
			$wp_query->is_search = false;
			$wp_query->is_feed = false;
			$wp_query->is_comment_feed = false;
			$wp_query->is_trackback = false;
			$wp_query->is_home = false;
			$wp_query->is_embed = false;
			$wp_query->is_404 = false;
			$wp_query->is_paged = false;
			$wp_query->is_admin = false;
			$wp_query->is_preview = false;
			$wp_query->is_robots = false;
			$wp_query->is_posts_page = false;
			$wp_query->is_post_type_archive = false;

			switch ($args['post_type']) {

				case 'page':
					$wp_query->is_page = true;
					$wp_query->is_singular = true;
					break;

				case 'post':
					break;

				default: // custom post_type
					break;
			}

			$GLOBALS['wp_query'] = $wp_query;
			$GLOBALS['posts'] = $posts;
			$GLOBALS['post'] = $post;
			$wp->register_globals();

			wp_cache_add($post->ID, $post, 'posts');
		}

		return $posts;
	}
}
