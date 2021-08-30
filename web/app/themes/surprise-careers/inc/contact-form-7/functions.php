<?php

// intercept contact form 7 before email send
add_action( 'wpcf7_before_send_mail', 'surprise_on_before_cf7_send_mail' );

add_filter( 'shortcode_atts_wpcf7', 'surprise_shortcode_atts_wpcf7_filter', 10, 3 );

add_action( 'wpcf7_submit', 'store_job_application', 10, 2 );

function surprise_create_attachment( $filename ) {
	// Check the type of file. We'll use this as the 'post_mime_type'.
	$filetype = wp_check_filetype( basename( $filename ), null );

	// Get the path to the upload directory.
	$wp_upload_dir = wp_upload_dir();

	$attachFileName = $wp_upload_dir['path'] . '/' . basename( $filename );
	copy( $filename, $attachFileName );
	// Prepare an array of post data for the attachment.
	$attachment = array(
		'guid'           => $attachFileName,
		'post_mime_type' => $filetype['type'],
		'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
		'post_content'   => '',
		'post_status'    => 'inherit'
	);

	// Insert the attachment.
	$attach_id = wp_insert_attachment( $attachment, $attachFileName );

	// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
	require_once( ABSPATH . 'wp-admin/includes/image.php' );

	// Generate the metadata for the attachment, and update the database record.
	$attach_data = wp_generate_attachment_metadata( $attach_id, $attachFileName );
	wp_update_attachment_metadata( $attach_id, $attach_data );

	return $attach_id;
}

function surprise_on_before_cf7_send_mail( \WPCF7_ContactForm $contactForm ) {
	$submission = WPCF7_Submission::get_instance();
	if ( $submission ) {
		$uploaded_files = $submission->uploaded_files();
		if ( $uploaded_files ) {
			foreach ( $uploaded_files as $fieldName => $filepath ) {
				//cf7 5.4
				if ( is_array( $filepath ) ) {
					foreach ( $filepath as $key => $value ) {
						$data = surprise_create_attachment( $value );
					}
				} else {
					$data = surprise_create_attachment( $filepath );
				}
			}
		}
	}
}


function surprise_shortcode_atts_wpcf7_filter( $out, $pairs, $atts ) {
	$my_attr = 'job-id';

	if ( isset( $atts[ $my_attr ] ) ) {
		$out[ $my_attr ] = $atts[ $my_attr ];
	}

	return $out;
}

function store_job_application( $that, $result ) {
	$submission     = WPCF7_Submission::get_instance();
	$posted_data    = $submission->get_posted_data();
	$uploaded_files = $submission->uploaded_files();

	$cv = $uploaded_files['candidate_cv'];

	if ( $submission->get_status() == 'mail_sent' ) {
		$application_id = wp_insert_comment( [
			'comment_post_ID'      => $posted_data['job-id'],
			'comment_author'       => $posted_data['candidate_first_name'] . ' ' . $posted_data['candidate_last_name'],
			'comment_author_email' => $posted_data['candidate_email'],
			'comment_content'      => $posted_data['candidate_comment'],
			'comment_type'         => 'application'
		] );

		if ( isset( $cv ) && ! empty( $cv ) ) {
			$attach_id = surprise_create_attachment( $cv[0] );
			update_field( 'cv', $attach_id, 'comment_' . $application_id );
		}

		if ( isset( $posted_data['candidate_phone'] ) && ! empty( $posted_data['candidate_phone'] ) ) {
			update_field( 'phone', $posted_data['candidate_phone'], 'comment_' . $application_id );
		}

	}
}