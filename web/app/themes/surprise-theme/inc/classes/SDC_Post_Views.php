<?php

/**
 * Populat Posts
 * @since Surprise 1.0
 */

if (!class_exists('SDC_Post_Views')) {
  class SDC_Post_Views {

    // Post View Metaname
    const COUNT_KEY = 'sdc_post_views_count';

    public function __construct() {
      remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
      add_action( 'wp_head', array($this, 'surprise_track_post_views'));
      add_filter('manage_posts_columns', array($this, 'surprise_posts_column_views'));
      add_action('manage_posts_custom_column', array($this, 'surprise_posts_custom_column_views'), 5, 2);
    }

    /**
     * Set post post view in postmeta
     */
    public static function surprise_set_post_views($post_id) {
      $count = get_post_meta($post_id, self::COUNT_KEY, true);

      if($count == '') {
          $count = 0;
          delete_post_meta($post_id, self::COUNT_KEY);
          add_post_meta($post_id, self::COUNT_KEY, '1');
      } else {
          $count++;
          update_post_meta($post_id, self::COUNT_KEY, $count);
      }
    }
    
    /**
     * Track Post View
     */
    public static function surprise_track_post_views ($post_id) {
      if ( !is_single() ) return;
       
      if ( empty ( $post_id) ) {
          global $post;
          $post_id = $post->ID;    
      }
      
      self::surprise_set_post_views($post_id);
    }

    /**
     * Get Post View
     */
    public static function surprise_get_posts_view($postID) {
	    $count = get_post_meta($postID, self::COUNT_KEY, true);
	    if ($count == '') {
	  	  delete_post_meta($postID, self::COUNT_KEY);
	  	  add_post_meta($postID, self::COUNT_KEY, '0');
	  	  return "0";
	    }
	    return $count;
    }


    /**
     * Add Column View in Posts Page
     */
    public function surprise_posts_column_views($defaults) {
      $defaults['posts_views'] = __('Views', 'surprise');
      return $defaults;
    }

    /**
     * Show View in Posts Page
     */
    public function surprise_posts_custom_column_views($column_name, $id) {
      if ($column_name === 'posts_views') {
        echo self::surprise_get_posts_view(get_the_ID());
      }
    }
  }  
}