<?php

/**
 * ExcerptMoreLink class
 * 
 * @package wpbootstrap
 */



namespace WPBootstrap\WPFilters;

use WPBootstrap\WPFilter;



class ExcerptMoreLink extends WPFilter
{



    /**
     * initialize
     */
    public function __construct()
    {
        parent::__construct('the_excerpt', 10, 1);
    }



    /**
     * callback
     */
    public function callback($value, $args = null)
    {
        $excerpt = $value;
        $collection = $this->collection;
        $default = __('Read more …', I18N_TEXTDOMAIN);

        if (isset($collection[0]) && $collection[0] !== null) {
            $text = $collection[0];
        } else {
            $text = $default;
        }

        // if setted to false avoid the link at all
        if (isset($collection[0]) && $collection[0] !== false) {
            $excerpt .= ' <a class="read-more" href="' . get_permalink() . '">' . $text . '</a>';
        }

        return $excerpt;
    }
}
