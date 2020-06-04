<?php

/**
 * YouTube class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap;



class YouTube
{



	/**
	 * Construct
	 */
	public function __construct()
	{
		/* add oembed handler for youtube-noocokie.com */
		wp_embed_register_handler('ytnocookie', '#https?://www\.youtube\-nocookie\.com/embed/([a-z0-9\-_]+)#i', [$this, 'wp_embed_handler_ytnocookie']);
		/* enable these to switch to youtube-nocookie automagically! */
		wp_embed_register_handler('ytnormal', '#https?://www\.youtube\.com/watch\?v=([a-z0-9\-_]+)#i', [$this, 'wp_embed_handler_ytnocookie']);
		wp_embed_register_handler('ytnormal2', '#https?://www\.youtube\.com/watch\?feature=player_embedded&amp;v=([a-z0-9\-_]+)#i', [$this, 'wp_embed_handler_ytnocookie']);
	}



	public function wp_embed_handler_ytnocookie($matches, $attr, $url, $rawattr)
	{
		$embed = sprintf(
			'<iframe src="https://www.youtube-nocookie.com/embed/%2$s?rel=0" width="%3$s" height="%4$s" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>',
			get_template_directory_uri(),
			esc_attr($matches[1]),
			$attr['width'],
			$attr['height']
		);

		return apply_filters('embed_ytnocookie', $embed, $matches, $attr, $url, $rawattr);
	}
}
