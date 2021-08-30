<?php

if ( ! function_exists( 'surprise_comment_submit_button' ) ) {
  /**
	 * Change submit button text in wordpress comment form
	 *
	 * @since Surprise 1.0
	 *
	 * @return void
	 */
  function surprise_comment_submit_button( $defaults ) {
    $defaults['label_submit'] = __('Leave Comment', 'surprise');
    print_r($defaults);
    return $defaults;
  }
  // add_filter( 'comment_form_defaults', 'surprise_comment_submit_button', 25 );
}

if ( ! function_exists( 'surprise_add_comment_field' ) ) {
  /**
	 * Add field to the comment form
	 *
	 * @since Surprise 1.0
	 *
	 */
  function surprise_add_comment_field( $fields ) {
    $placeholder_author = __( 'Name', 'surprise' );
    $placeholder_email = __( 'Email', 'surprise' );
    $placeholder_company = __('Company (Optional)', 'surprise');
    $commenter = wp_get_current_commenter();

    unset( $fields[ 'url' ] );

    $fields['author'] = '<p class="comment-form-author"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="25" tabindex="1" aria-required="true" title="'. __( 'Your Name (required)','surprise' ) .'" placeholder="'. $placeholder_author .'" required />';

    $fields['email'] = '<p class="comment-form-email"><input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="25" tabindex="2" aria-required="true" title="'. __( 'Email Address (required)', 'surprise' ) .'" placeholder="'. $placeholder_email .'" required />';

    $fields['company'] = '<p class="comment-form-company"><input id="comment_company" name="company" size="25" type="text" tabindex="3" placeholder="'.$placeholder_company.'" /></p>';

    return $fields;
  }
  add_filter( 'comment_form_default_fields', 'surprise_add_comment_field');
}

if ( !function_exists ('surprise_comment_form_field_comment') ) {
  /**
   * Customize the comment form comment field
   * @param  string $field
   * @return string
   */
  function surprise_comment_form_field_comment($field) {
    $title = __( 'Comment', 'surprise' );
    $placeholder =  __( 'Comment','my-text-domain' );

  	$field = '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="1" tabindex="4" title="' . $title . '" placeholder="' . $placeholder . '" aria-required="true"></textarea>';

  	return $field;

  }
  add_filter('comment_form_field_comment', 'surprise_comment_form_field_comment');
}


if ( ! function_exists( 'surprise_save_comment_field_data' ) ) {
  /**
	 * Save the field value in the comment metadata
	 *
	 * @since Surprise 1.0
	 *
	 */  
  function surprise_save_comment_field_data( $comment_id ) {  
    if ( ! isset($_POST['company'])) return;
    $company = $phone = wp_filter_nohtml_kses($_POST['company']);
  	add_comment_meta( $comment_id, 'company', $company );  
  }
  add_action( 'comment_post', 'surprise_save_comment_field_data' );
}

/**
 * Add the title to our admin area, for editing, etc
 */
if ( ! function_exists( 'surprise_save_comment_field_data' ) ) {
  /**
	 * Save the field value in the comment metadata
	 *
	 * @since Surprise 1.0
	 *
	 */  
  function surprise_save_comment_field_data( $comment_id ) {  
    if ( ! isset($_POST['company'])) return;
    $company = wp_filter_nohtml_kses($_POST['company']);
  	add_comment_meta( $comment_id, 'company', $company );  
  }
  add_action( 'comment_post', 'surprise_save_comment_field_data' );
}

if ( ! function_exists( 'surprise_comment_add_meta_box' ) ) {
  /**
	 * Add comment metabox in admin panel
	 *
	 * @since Surprise 1.0
	 *
	 */
  function surprise_comment_add_meta_box() {
      add_meta_box( 'title', __( 'Comment Metadata', 'surprise' ), 'surprise_extend_comment_meta_box', 'comment', 'normal', 'high' );
  }
  add_action( 'add_meta_boxes_comment', 'surprise_comment_add_meta_box' );
}

if ( ! function_exists( 'surprise_extend_comment_meta_box' ) ) {
  /**
	 * Extend comment metabox field in admin panel
	 *
	 * @since Surprise 1.0
	 *
	 */
  function surprise_extend_comment_meta_box ( $comment ) {
      $company = get_comment_meta( $comment->comment_ID, 'company', true );
      wp_nonce_field( 'company_comment_update', 'company_comment_update', false );
      ?>
      <p>
          <label for="company"><?php _e( 'Company', 'surprise' ); ?></label>
          <input type="text" name="company" value="<?php echo esc_attr( $company ); ?>" class="widefat" />
      </p>
      <?php
  }
}

if ( ! function_exists( 'surprise_update_edit_comment' ) ) {
  /**
	 * Edit comment data in admin panel
	 *
	 * @since Surprise 1.0
	 *
	 */  
  function surprise_update_edit_comment( $comment_id ) {   
  	if( ! isset( $_POST['company_comment_update'] ) || ! wp_verify_nonce( $_POST['company_comment_update'], 'company_comment_update' ) ) return;
  
    update_comment_meta( $comment_id, 'company', esc_attr( $_POST['company'] ) );
  }
  add_action( 'edit_comment', 'surprise_update_edit_comment' );
}

if ( ! function_exists( 'surprise_add_custom_fields_to_edit_comment_screen' ) ) {
  /**
	 * Add custom fields to edit comment screen
	 *
	 * @since Surprise 1.0
	 *
	 */
  function surprise_add_custom_fields_to_edit_comment_screen() {
    $screen = get_current_screen();
    add_filter("manage_{$screen->id}_columns", 'surprise_add_custom_comment_columns');
  }

  function surprise_add_custom_comment_columns($cols) {
    $cols['company'] = __('Company', 'surprise');
    return $cols;
  }
  add_action('load-edit-comments.php', 'surprise_add_custom_fields_to_edit_comment_screen');
}

if ( ! function_exists( 'surprise_custom_comment_column' ) ) {
  /**
	 * Output custom field data in custom comment column
	 *
	 * @since Surprise 1.0
	 *
	 */
  function surprise_custom_comment_column($col, $comment_id) {   
    switch($col) {
      case 'company':
        if($company = get_comment_meta($comment_id, 'company', true)){
          echo esc_html($company);
        } else {
          esc_html_e('No Company Submitted', 'surprise');
        }
    }
  }
  add_action( 'manage_comments_custom_column', 'surprise_custom_comment_column', 10, 2 );
}

if ( ! function_exists( 'surprise_change_comment_fields_order' ) ) {
  /**
	 * Comment form fields order
	 *
	 * @since Surprise 1.0
	 *
	 */
  function surprise_change_comment_fields_order( $comment_fields ) {  
   	// order rules
  	$order = array( 'author', 'email', 'company', 'comment', 'cookies' );  
  	// new array with changed order
  	$new_fields = array();  
  	foreach( $order as $index ) {
  		$new_fields[ $index ] = $comment_fields[ $index ];
  	}  
  	return $new_fields;
  
  }
  add_action( 'comment_form_fields', 'surprise_change_comment_fields_order', 25 );
}

if ( ! function_exists ( 'surprise_comment_author_link' ) ) {
  /**
	 * Add metadata to the comment author link
	 *
	 * @since Surprise 1.0
	 *
	 */
  function surprise_comment_author_link( $author ) {
    $company = get_comment_meta( get_comment_ID(), 'company', true );
    if ( $company )
      $author .= " ($company)";
  	return $author;
  }
  add_filter( 'get_comment_author_link',	'surprise_comment_author_link' );
}