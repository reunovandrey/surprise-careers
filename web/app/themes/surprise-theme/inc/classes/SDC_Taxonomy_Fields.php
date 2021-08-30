<?php

/**
 * Add custom fields to taxonomy page
 * @since Surprise 1.0
 */

if (!class_exists('SDC_Taxonomy_Fields')) {
  class SDC_Taxonomy_Fields {


    protected $placeholder_img = "/assets/public/images/placeholder-600x690.png";

    public function __construct() {
      //
     }

    /**
     * Initialize the class and start calling our hooks and filters
     */
    public function init() {
      // Image actions
      add_action( 'category_add_form_fields',   array( $this, 'add_category_image' ), 10, 2 );
      add_action( 'created_category',           array( $this, 'save_category_image' ), 10, 2 );
      add_action( 'category_edit_form_fields',  array( $this, 'update_category_image' ), 10, 2 );
      add_action( 'edited_category',            array( $this, 'updated_category_image' ), 10, 2 );
      add_action( 'admin_enqueue_scripts',      array( $this, 'load_media' ) );
      add_action( 'admin_footer',               array( $this, 'add_script' ) );
    }

    public function load_media() {
      wp_enqueue_media();
     }

    /**
     * Add a form field in the new category page
     * @since 1.0.0
     */
    public function add_category_image ( $taxonomy ) { ?>
      <div class="form-field term-group">
        <label for="surprise_category_image"><?php _e('Image', 'surprise'); ?></label>
        <input type="hidden" id="surprise_category_image" name="surprise_category_image" class="custom_media_url" value="">
        <div id="category-image-wrapper"></div>
        <p>
          <input type="button" class="bttn button-primary bttn_upload_media" id="bttn_upload_media" name="bttn_upload_media" value="<?php _e( 'Add Image', 'surprise' ); ?>" />
          <input type="button" class="bttn button-secondary bttn_remove_media" id="bttn_remove_media" name="bttn_remove_media" value="<?php _e( 'Remove Image', 'surprise' ); ?>" />
        </p>
      </div>

      <div class="form-field term-group">
        <label for="surprise_category_color"><?php _e('Color', 'surprise'); ?></label>
        <input type="color" id="surprise_category_color" name="surprise_category_color" class="surprise_category_color" value="">
      </div>
    <?php
    }


    /**
     * Edit the form field
     * @since 1.0.0
     */
    public function update_category_image ( $term, $taxonomy ) {
      //put the term ID into a variable
	    $term_id = $term->term_id;
      //retrieve the start and ends values
      $image_id = get_term_meta ( $term_id, 'surprise_category_image', true );
      $color = get_term_meta ( $term_id, 'surprise_category_color', true );
      if ($image_id) {
        $image = wp_get_attachment_thumb_url($image_id);
      } else {
        $image = get_stylesheet_directory_uri() . $this->placeholder_img;
      }
      ?>
      <tr class="form-field term-group-wrap">
        <th scope="row">
          <label for="surprise_category_image"><?php _e( 'Image', 'surprise' ); ?></label>
        </th>
        <td>
          <input type="hidden" id="surprise_category_image" name="surprise_category_image" value="<?php echo $image_id; ?>">
          <div id="category-image-wrapper"><img src="<?php echo esc_url($image); ?>" width="60px" height="60px" /></div>
          <p>
            <input type="button" class="bttn button-primary bttn_upload_media" id="bttn_upload_media" name="bttn_upload_media" value="<?php _e( 'Add Image', 'surprise' ); ?>" />
            <input type="button" class="bttn button-secondary bttn_remove_media" id="bttn_remove_media" name="bttn_remove_media" value="<?php _e( 'Remove Image', 'surprise' ); ?>" />
          </p>
        </td>
      </tr>

      <tr class="form-field term-group-wrap">
        <th scope="row">
          <label for="surprise_category_color"><?php _e('Color', 'surprise'); ?></label>
        </th>
        <td>
          <input type="color" id="surprise_category_color" name="surprise_category_color" class="surprise_category_color" value="<?php echo $color; ?>">
        </td>
      </tr>
    <?php
    }

    /**
     * Save the form field
     * @since 1.0.0
     */
    public function save_category_image ( $term_id, $tt_id ) {
      if( isset( $_POST['surprise_category_image'] ) && '' !== $_POST['surprise_category_image'] ) {
        $image = $_POST['surprise_category_image'];
        add_term_meta( $term_id, 'surprise_category_image', $image, true );
      }

      if( isset( $_POST['surprise_category_color'] ) && '' !== $_POST['surprise_category_color'] ) {
        $color = $_POST['surprise_category_color'];
        add_term_meta( $term_id, 'surprise_category_color', $color, true );
      }
    }

    /**
     * Update the form field value
     * @since 1.0.0
     */
    public function updated_category_image ( $term_id, $tt_id ) {
      if( isset( $_POST['surprise_category_image'] ) && '' !== $_POST['surprise_category_image'] ){
        $image = $_POST['surprise_category_image'];
        update_term_meta ( $term_id, 'surprise_category_image', $image );
      } else {
        update_term_meta ( $term_id, 'surprise_category_image', '' );
      }

      if( isset( $_POST['surprise_category_color'] ) && '' !== $_POST['surprise_category_color'] ){
        $color = $_POST['surprise_category_color'];
        update_term_meta ( $term_id, 'surprise_category_color', $color );
      } else {
        update_term_meta ( $term_id, 'surprise_category_color', '' );
      }
    }

    /**
     * Add script
     * @since 1.0.0
     */
    public function add_script() { ?>
      <script>
        jQuery(document).ready( function($) {
          function surprise_media_upload(button_class) {
            var _custom_media = true,
              _orig_send_attachment = wp.media.editor.send.attachment;

            $('body').on('click', button_class, function(e) {
              var button_id = '#'+$(this).attr('id');
              var send_attachment_bkp = wp.media.editor.send.attachment;
              var button = $(button_id);
              _custom_media = true;

              wp.media.editor.send.attachment = function(props, attachment) {
                if ( _custom_media ) {
                  $('#surprise_category_image').val(attachment.id);
                  $('#category-image-wrapper').html('<img class="custom_media_image" src="<?php echo get_stylesheet_directory_uri() . $this->placeholder_img; ?>" style="width:60px;height:60px;" />');
                  $('#category-image-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
                } else {
                  return _orig_send_attachment.apply( button_id, [props, attachment] );
                }
               }
            wp.media.editor.open(button);
            return false;
          });
        }

        surprise_media_upload('.bttn_upload_media');

        $('body').on('click','.bttn_remove_media',function() {
          $('#surprise_category_image').val('');
          $('#category-image-wrapper').html('<img class="custom_media_image" src="<?php echo get_stylesheet_directory_uri() . $this->placeholder_img; ?>" style="width:60px;height:60px;" />');
        });

        $(document).ajaxComplete(function(event, xhr, settings) {
          var queryStringArr = settings.data.split('&');
          if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
            var xml = xhr.responseXML;
            $response = $(xml).find('term_id').text();
            if($response!=""){
              // Clear the thumb image
              $('#category-image-wrapper').html('');
            }
          }
        });
      });
    </script>
    <?php
    }

  }

  $sdc_taxonomy_field = new SDC_Taxonomy_Fields();
  $sdc_taxonomy_field->init();
}