<?php
/**
 * Extend Wordpress default comments functionality 
 * @since Surprise 1.0
 */
if ( ! class_exists( 'SDC_Comments' ) ) {
  class SDC_Comments {

    public function __construct()
    {
      add_filter( 'comment_form_default_fields',    array($this, 'surprise_remove_url_field'), 25 );
      add_filter( 'comment_form_default_fields',    array($this, 'surprise_add_comment_field') );
      add_filter( 'comment_form_field_comment',     array($this, 'surprise_comment_form_field_comment') );
      add_action( 'comment_form_fields',            array($this, 'surprise_change_comment_fields_order'), 25 );
      // add_action( 'comment_post',                   array($this, 'surprise_save_comment_field_data') );
      // add_action( 'add_meta_boxes_comment',         array($this, 'surprise_comment_add_meta_box') );
      // add_action( 'edit_comment',                   array($this, 'surprise_update_edit_comment') );
      // add_action('load-edit-comments.php',          array($this, 'surprise_add_custom_fields_to_edit_comment_screen') );
      // add_action( 'manage_comments_custom_column',  array($this, 'surprise_custom_comment_column'), 10, 2 );
      
      // add_filter( 'get_comment_author_link',	      array($this, 'surprise_comment_author_link') );
    }

    /**
     * Remove url field to the comment form
     * @return void
     */
    public static function surprise_remove_url_field( $fields ) {
      unset( $fields[ 'url' ] );
      return $fields;
    }    
    
    /**
     * Add field to the comment form
     * @param  string $field
     * @return string
     */
    public static function surprise_add_comment_field( $fields ) {
      $placeholder_author = __( 'Name', 'surprise' );
      $placeholder_email = __( 'Email', 'surprise' );
      $placeholder_company = __('Company (Optional)', 'surprise');
  
      $fields['author'] = '<p class="comment-form-author ff"><input id="author" name="author"type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1"aria-required="true" title="'. __( 'Your Name (required)','surprise' ) .'" placeholder="'.$placeholder_author .'" required />';
  
      $fields['email'] = '<p class="comment-form-email"><input id="email" name="email" type="email"value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" tabindex="2"aria-required="true" title="'. __( 'Email Address (required)', 'surprise' ) .'" placeholder="'.$placeholder_email .'" required />';
  
      $fields['company'] = '<p class="comment-form-company"><input id="comment_company"name="company" size="30" type="text" tabindex="3" placeholder="'.$placeholder_company.'" /><p>';
  
      return $fields;
    }    

    /**
     * Customize the comment form comment field
     * @param  string $field
     * @return string
     */
    public static function surprise_comment_form_field_comment($field) {
      $title = __( 'Comment', 'surprise' );
      $placeholder =  __( 'Comment','my-text-domain' );
  
      $field = '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45"rows="8" tabindex="4" title="' . $title . '" placeholder="' . $placeholder . '"aria-required="true"></textarea>';
  
      return $field;  
    }
    
    /**
     * Comment form fields order
     *
     * @since Surprise 1.0
     *
     */
    public static function surprise_change_comment_fields_order( $comment_fields ) {  
      // order rules
     $order = array( 'author', 'email', 'company', 'comment', 'cookies' );  
     // new array with changed order
     $new_fields = array();  
     foreach( $order as $index ) {
       $new_fields[ $index ] = $comment_fields[ $index ];
     }  
     return $new_fields;    
   }
  
 
    /* Add the title to our admin area, for editing, etc */

    /**
     * Save the field value in the comment metadata
     */  
    protected static function surprise_save_comment_field_data( $comment_id ) {  
      if ( ! isset($_POST['company'])) return;
      $company = wp_filter_nohtml_kses($_POST['company']);
      add_comment_meta( $comment_id, 'company', $company );  
    }

    /**
     * Add comment metabox in admin panel
     */
    protected function surprise_comment_add_meta_box() {
        add_meta_box( 'title', __( 'Comment Metadata', 'surprise' ),$this->surprise_extend_comment_meta_box, 'comment', 'normal', 'high' );
    }

    /**
     * Extend comment metabox field in admin panel
     */
    protected static function surprise_extend_comment_meta_box ( $comment ) {
        $company = get_comment_meta( $comment->comment_ID, 'company', true );
        wp_nonce_field( 'company_comment_update', 'company_comment_update', false );
        ?>
        <p>
            <label for="company"><?php _e( 'Company', 'surprise' ); ?></label>
            <input type="text" name="company" value="<?php echo esc_attr( $company ); ?>"class="widefat" />
        </p>
        <?php
    }
    /**
     * Edit comment data in admin panel
     */  
    protected static function surprise_update_edit_comment( $comment_id ) {   
      if( ! isset( $_POST['company_comment_update'] ) || ! wp_verify_nonce( $_POST['company_comment_update'], 'company_comment_update' ) ) return;
    
      update_comment_meta( $comment_id, 'company', esc_attr( $_POST['company'] ) );
    }
    
    /**
     * Add custom fields to edit comment screen
     */
    protected function surprise_add_custom_fields_to_edit_comment_screen() {
      $screen = get_current_screen();
      add_filter("manage_{$screen->id}_columns", array($this, 'surprise_add_custom_comment_columns'));
    }
  
    private static function surprise_add_custom_comment_columns($cols) {
      $cols['company'] = __('Company', 'surprise');
      return $cols;
    }
    
    /**
     * Output custom field data in custom comment column
     */
    protected static function surprise_custom_comment_column($col, $comment_id) {   
      switch($col) {
        case 'company':
          if($company = get_comment_meta($comment_id, 'company', true)){
            echo esc_html($company);
          } else {
            esc_html_e('No Company Submitted', 'surprise');
          }
      }
    }
    
    
    
    /**
     * Add metadata to the comment author link
     *
     * @since Surprise 1.0
     *
     */
    protected static function surprise_comment_author_link( $author ) {
      $company = get_comment_meta( get_comment_ID(), 'company', true );
      if ( $company )
        $author .= " ($company)";
      return $author;
    }
  }
}