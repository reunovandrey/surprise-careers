<?php
if (!class_exists('SDC_Widget_Social_Icons')) {
	class SDC_Widget_Social_Icons extends WP_Widget	{
		/**
     * Register widget with WordPress.
     */
		public function __construct()	{
			parent::__construct(
				'social_widget', // Base ID
				'SDC Social Links', // Name
				array(
					'description' => __('Social Links Widget', 'surprise'),
				) // Args
			);
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
			// outputs the content of the widget
			extract( $args );
      $title = apply_filters( 'widget_title', $instance['title'] ); 
      echo $before_widget;
      if ( ! empty( $title ) ) {
        echo $before_title . $title . $after_title;				
      }
			if ( have_rows( 'social_list', 'widget_' . $widget_id ) ) : ?>
				<ul class="social-list">
				<?php 
				while ( have_rows( 'social_list', 'widget_' . $widget_id ) ) : the_row();
					$link   = get_sub_field('link');
					$url    = $link['url'];
					$label  = $link['title'];
					$target = $link['target'] ?: '_self';      
					$icon   = surprise_get_icon( get_sub_field('icon') );
					?>					
					<li class="social-list-item">
						<a href="<?php echo $url; ?>" class="social-list-link" aria-label="<?php echo $label; ?>" target="<?php echo $target; ?>">
							<?php echo $icon; ?>
							<?php echo $label; ?>
						</a>
					</li>					
				<?php endwhile; ?>
				</ul>
      <?php 			
			endif;
			echo $after_widget;
		}

		/**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
		public function form( $instance ) {
			$title = isset( $instance['title']) ? $instance['title'] : esc_html__( 'Connect', 'surprise' );
			?>
			<p>
				<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
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
    public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

			return $instance;
		}
	}

	add_action( 'widgets_init', 'surprise_register_social_widget' );
     
	function surprise_register_social_widget() { 
    register_widget( 'SDC_Widget_Social_Icons' ); 
	}
}
