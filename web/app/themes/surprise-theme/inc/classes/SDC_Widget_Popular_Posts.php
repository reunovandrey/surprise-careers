<?php

use function PHPSTORM_META\type;

if (!class_exists('SDC_Widget_Popular_Posts')) {
  class SDC_Widget_Popular_Posts extends WP_Widget {
    /**
     * Register popular posts widget with WordPress.
     */
    public function __construct() {
      $widget_ops = array(
        'classname'                   => 'widget_popular_posts',
        'description'                 => __( 'Your site&#8217;s most popular Posts.' ),
        'customize_selective_refresh' => true,
      );
      parent::__construct( 'popular-posts', __( 'Popular Posts' ), $widget_ops );
		  $this->alt_option_name = 'widget_popular_posts';
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
      if ( ! isset( $args['widget_id'] ) ) {
        $args['widget_id'] = $this->id;
      }
      $default_title  = __( 'Popular Posts' );
      $title          = ( ! empty( $instance['title'] ) ) ? $instance['title'] : $default_title;
      /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
      $title          = apply_filters( 'widget_title', $title, $instance, $this->id_base );

      $number         = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		  if ( ! $number ) {
			  $number = 5;
		  }

      $r = new WP_Query(
        /**
         * Filters the arguments for the Popular Posts widget.
         *
         * @since 3.4.0
         * @since 4.9.0 Added the `$instance` parameter.
         *
         * @see WP_Query::get_posts()
         *
         * @param array $args     An array of arguments used to retrieve the popular posts.
         * @param array $instance Array of settings for the current widget.
         */
        apply_filters(
          'widget_posts_args',
          array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
            'meta_key'            => 'sdc_post_views_count',
            'orderby'             => 'meta_value_num',
            'order'               => 'DESC',
          ),
          $instance
        )
      );
  
      if ( ! $r->have_posts() ) {
        return;
      }

      echo $args['before_widget'];
      if ( $title ) {
        echo $args['before_title'] . $title . $args['after_title'];
      }
      ?>

      <ul class="popular-posts-list">
        <?php foreach ( $r->posts as $populat_post ) :
          $post_title   = get_the_title( $populat_post->ID );
          $title        = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)' );
          ?>
          <li class="popular-posts-item">
            <?php
            surprise_get_categories_list($populat_post->ID); ?>
            <h4 class="post-title h5">
              <a href="<?php the_permalink( $populat_post->ID ); ?>"><?php echo $title; ?></a>
            </h4>
            <?php surprise_posted_on($populat_post->ID); ?>
          </li>
        <?php endforeach; ?>
      </ul>
      <?php
      echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
      $title  = isset($instance['title']) ? $instance['title'] : esc_html__('Popular Posts', 'surprise');
      $number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
      ?>
      <p>
        <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'surprise'); ?></label>
        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
      </p>
      <p>
			  <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'surprise' ); ?></label>
			  <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
	  	</p>
<?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
      $instance           = $old_instance;
      $instance['title']  = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title'])  : '';
      $instance['number'] = (!empty($new_instance['number'])) ? (int) $new_instance['number']  : 5;

      return $instance;
    }
  }

  add_action('widgets_init', 'surprise_register_popular_posts_widget');

  function surprise_register_popular_posts_widget() {
    register_widget('SDC_Widget_Popular_Posts');
  }
}
