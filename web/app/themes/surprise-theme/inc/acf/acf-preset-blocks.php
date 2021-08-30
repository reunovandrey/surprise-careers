<?php

/**
 * ACF - Preset Blocks
 *
 * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
 *
 * @package WordPress
 * @subpackage Surprise
 * @since Surprise 1.0
 *
 */

if (function_exists('acf_add_local_field_group')) :

  /**
   * Preset: Title
   */
  acf_add_local_field_group(
    array(
      'key' => 'group_acf-title',
      'title' => 'Preset: Title',
      'fields' => array(
        array(
          'key' => 'field_acf-heading',
          'label' => 'Block Title',
          'name' => 'block_title',
          'type' => 'text',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '70',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'maxlength' => '',
        ),
        array(
          'key' => 'field_acf-tag',
          'label' => 'Tag',
          'name' => 'tag',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '15',
            'class' => '',
            'id' => '',
          ),
          'choices' => array(
            'div' => 'DIV',
            'p' => 'P',
            'h1' => 'H1',
            'h2' => 'H2',
            'h3' => 'H3',
            'h4' => 'H4',
            'h5' => 'H5',
            'h6' => 'H6',
          ),
          'default_value' => false,
          'allow_null' => 0,
          'multiple' => 0,
          'ui' => 1,
          'ajax' => 0,
          'return_format' => 'value',
          'placeholder' => '',
        ),
        array(
          'key' => 'field_acf-size',
          'label' => 'Size',
          'name' => 'size',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '15',
            'class' => '',
            'id' => '',
          ),
          'choices' => array(
            'h1' => 'H1',
            'h2' => 'H2',
            'h3' => 'H3',
            'h4' => 'H4',
            'h5' => 'H5',
            'h6' => 'H6',
            'h7' => 'H7',
          ),
          'default_value' => false,
          'allow_null' => 0,
          'multiple' => 0,
          'ui' => 1,
          'ajax' => 0,
          'return_format' => 'value',
          'placeholder' => '',
        ),
      ),
      'location' => array(
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'post',
          ),
        ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => true,
      'description' => '',
    )
  );

  /**
   * Preset: Block Header
   */
  acf_add_local_field_group(
    array(
      'key' => 'group_block-header',
      'title' => 'Preset: Block Header',
      'fields' => array(
        array(
          'key' => 'field_acf-title',
          'label' => 'Title',
          'name' => 'title',
          'type' => 'clone',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'clone' => array(
            0 => 'group_acf-title',
          ),
          'display' => 'seamless',
          'layout' => 'block',
          'prefix_label' => 0,
          'prefix_name' => 0,
        ),
        array(
          'key' => 'field_acf-subheading',
          'label' => 'Subheading',
          'name' => 'subheading',
          'type' => 'wysiwyg',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '100',
            'class' => '',
            'id' => '',
          ),
          'default_value' => '',
          'tabs' => 'all',
          'toolbar' => 'full',
          'media_upload' => 1,
          'delay' => 0,
        ),
      ),
      'location' => array(
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'post',
          ),
        ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => true,
      'description' => '',
    )
  );

  /**
   * Preset: Block Settings
   */
  acf_add_local_field_group(
    array(
      'key' => 'group_block-settings',
      'title' => 'Preset: Section Settings',
      'fields' => array(
        array(
          'key' => 'field_acf-header-align',
          'label' => 'Header Align',
          'name' => 'header_align',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '25',
            'class' => '',
            'id' => '',
          ),
          'choices' => array(
            'left' => 'Left',
            'center' => 'Center',
            'right' => 'Right',
          ),
          'default_value' => false,
          'allow_null' => 0,
          'multiple' => 0,
          'ui' => 0,
          'return_format' => 'value',
          'ajax' => 0,
          'placeholder' => '',
        ),
        array(
          'key' => 'field_acf-subheading_style',
          'label' => 'Subheading Style',
          'name' => 'subheading_style',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '25',
            'class' => '',
            'id' => '',
          ),
          'choices' => array(
            'default' => 'Default',
            'big' => 'Big',
          ),
          'default_value' => false,
          'allow_null' => 0,
          'multiple' => 0,
          'ui' => 0,
          'return_format' => 'value',
          'ajax' => 0,
          'placeholder' => '',
        ),
        array(
          'key' => 'field_acf-padding-top',
          'label' => 'Padding Top',
          'name' => 'padding_top',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '25',
            'class' => '',
            'id' => '',
          ),
          'choices' => array(
            'pt-default' => 'Default (75px)',
            'pt-small' => 'Small (50px)',
            'pt-extra' => 'Extra (100px)',
            'pt-none' => 'None (0px)',
          ),
          'default_value' => false,
          'allow_null' => 0,
          'multiple' => 0,
          'ui' => 0,
          'return_format' => 'value',
          'ajax' => 0,
          'placeholder' => '',
        ),
        array(
          'key' => 'field_acf-padding-bottom',
          'label' => 'Padding Bottom',
          'name' => 'padding_bottom',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '25',
            'class' => '',
            'id' => '',
          ),
          'choices' => array(
            'pb-default' => 'Default (75px)',
            'pb-small' => 'Small (50px)',
            'pb-extra' => 'Extra (100px)',
            'pb-none' => 'None (0px)',
          ),
          'default_value' => false,
          'allow_null' => 0,
          'multiple' => 0,
          'ui' => 0,
          'return_format' => 'value',
          'ajax' => 0,
          'placeholder' => '',
        ),
      ),
      'location' => array(
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'post',
          ),
        ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => true,
      'description' => '',
    )
  );

  /**
   * Block: Post Content
   */
  acf_add_local_field_group(array(
    'key' => 'group_60f6c4ba90b79',
    'title' => 'Block: Post Content',
    'fields' => array(
    ),
    'location' => array(
      array(
        array(
          'param' => 'block',
          'operator' => '==',
          'value' => 'acf/post-content',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
  ));

endif;
