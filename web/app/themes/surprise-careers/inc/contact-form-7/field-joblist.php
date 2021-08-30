<?php

add_action( 'wpcf7_init', 'wpcf7_add_form_tag_surprise_joblist', 9 );

add_action( 'wpcf7_admin_init', 'wpcf7_add_tag_generator_surprise_joblist', 25 );

function wpcf7_add_form_tag_surprise_joblist() {
	wpcf7_add_form_tag( [ 'surprise_joblist', 'surprise_joblist*' ], 'wpcf7_select_joblist_form_tag_handler', true );
}

/**
 * @param array $tag field attributes [select_joblist]
 *
 * @return string html code
 */
function wpcf7_select_joblist_form_tag_handler( $tag ) {
	$tag = new WPCF7_FormTag( $tag );

	if ( empty( $tag->name ) ) {
		return '';
	}

	$validation_error = wpcf7_get_validation_error( $tag->name );

	$class = wpcf7_form_controls_class( $tag->type );

	if ( $validation_error ) {
		$class .= ' wpcf7-not-valid';
	}

	$atts = array();

	$atts['class']    = $tag->get_class_option( $class );
	$atts['id']       = $tag->get_id_option();
	$atts['tabindex'] = $tag->get_option( 'tabindex', 'int', true );

	if ( $tag->is_required() ) {
		$atts['aria-required'] = 'true';
	}

	$atts['aria-invalid'] = $validation_error ? 'true' : 'false';

	$include_blank  = $tag->has_option( 'include_blank' );
	$first_as_label = $tag->has_option( 'first_as_label' );

	$values = $tag->values;
	$labels = $tag->labels;


	$jobs = [];

	// Getting all non-empty categories excl. "Uncategorized"
	$categories = get_categories( [
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => 1,
		'exclude'    => '1'
	] );

	if ( ! empty( $categories ) ):
		foreach ( $categories as $category ):
			// Getting all Jobs from current category
			$query = new WP_Query( [
				'post_type'      => 'career',
				'posts_per_page' => - 1,
				'order'          => 'ASC',
				'cat'            => $category->term_id
			] );
			foreach ( $query->posts as $post ) {
				$jobs[ $category->name ][ $post->ID ] = $post->post_title;
			}
		endforeach;
	endif;

	if ( $include_blank || empty( $values ) ) {
		array_unshift( $labels, '---' );
		array_unshift( $values, '' );
	} elseif ( $first_as_label ) {
		$values[0] = '';
	}

	$html = '';
	$html .= '<option value="">Select a Vacancy...</option>';

	$highlite_job_id = ! empty( $_GET['job_id'] ) ? $_GET['job_id'] : false;

	foreach ( $jobs as $cat_name => $cat_jobs ) {
		$html .= '<optgroup label="' . $cat_name . '">';


		foreach ( $cat_jobs as $job_id => $job_title ) {
			$item_atts = wpcf7_format_atts( [
				'value'    => $job_id,
				'selected' => ( $job_id == $highlite_job_id ) ? 'selected' : ''
			] );
			$html      .= sprintf( '<option %1$s>%2$s</option>', $item_atts, esc_html( $job_title ) );
		}

		$html .= '</optgroup>';

	}
	$atts['placeholder'] = 'Select a Vacancy...';
	$atts['name']        = $tag->name;

	$atts = wpcf7_format_atts( $atts );

	$html = sprintf( '<span class="wpcf7-form-control-wrap %1$s"><select %2$s>%3$s</select>%4$s</span>',
		sanitize_html_class( $tag->name ), $atts, $html, $validation_error );

	return $html;
}

function wpcf7_add_tag_generator_surprise_joblist() {
	$tag_generator = WPCF7_TagGenerator::get_instance();
	$tag_generator->add( 'joblist', 'Job list', 'wpcf7_tag_generator_surprise_joblist' );
}

/**
 *   Shortcode settings modal window
 *
 * @param object $contact_form объект формы со всеми настройками и параметрами
 * @param array $args массив с параметрами кнопки id, title, content
 *
 */
function wpcf7_tag_generator_surprise_joblist( $contact_form, $args = '' ) {
	$args = wp_parse_args( $args, array() );
	?>
    <div class="control-box">
        <fieldset>
            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row">
						<?php echo esc_html( __( 'Field type', 'contact-form-7' ) ); ?>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
								<?php echo esc_html( __( 'Field type', 'contact-form-7' ) ); ?>
                            </legend>
                            <label>
                                <input type="checkbox"
                                       name="required"/> <?php echo esc_html( __( 'Required field', 'contact-form-7' ) ); ?>
                            </label>
                        </fieldset>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>">
							<?php echo esc_html( __( 'Name', 'contact-form-7' ) ); ?>
                        </label>
                    </th>
                    <td>
                        <input type="text" name="name" class="tg-name oneline"
                               id="<?php echo esc_attr( $args['content'] . '-name' ); ?>"/>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
						<?php echo esc_html( __( 'Options', 'contact-form-7' ) ); ?>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">
								<?php echo esc_html( __( 'Options', 'contact-form-7' ) ); ?>
                            </legend>
                            <textarea name="values" class="values"
                                      id="<?php echo esc_attr( $args['content'] . '-values' ); ?>"></textarea>
                            <label>
                                <input type="checkbox" name="include_blank"
                                       class="option"/> <?php echo esc_html( __( 'Insert a blank item as the first option', 'contact-form-7' ) ); ?>
                            </label>
                        </fieldset>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr( $args['content'] . '-id' ); ?>">
							<?php echo esc_html( __( 'Id attribute', 'contact-form-7' ) ); ?>
                        </label>
                    </th>
                    <td>
                        <input type="text" name="id" class="idvalue oneline option"
                               id="<?php echo esc_attr( $args['content'] . '-id' ); ?>"/>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>">
							<?php echo esc_html( __( 'Class attribute', 'contact-form-7' ) ); ?>
                        </label>
                    </th>
                    <td>
                        <input type="text" name="class" class="classvalue oneline option"
                               id="<?php echo esc_attr( $args['content'] . '-class' ); ?>"/>
                    </td>
                </tr>

                </tbody>
            </table>
        </fieldset>
    </div>

    <div class="insert-box">
        <input type="text" name="surprise_joblist" class="tag code" readonly="readonly" onfocus="this.select()"/>

        <div class="submitbox">
            <input type="button" class="button button-primary insert-tag"
                   value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>"/>
        </div>

        <br class="clear"/>

        <p class="description mail-tag">
            <label for="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>">
				<?php echo sprintf( esc_html( __( "To use the value input through this field in a mail field, you need to insert the corresponding mail-tag (%s) into the field on the Mail tab.", 'contact-form-7' ) ), '<strong><span class="mail-tag"></span></strong>' ); ?>
                <input type="text" class="mail-tag code hidden" readonly="readonly"
                       id="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>"/>
            </label>
        </p>
    </div>
	<?php
}