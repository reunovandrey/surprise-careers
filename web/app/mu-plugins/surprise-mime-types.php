<?php
/**
 * Plugin name: Surprise mime-types
 * Description: Adds SVG and JSON file formats to allowed list for upload.
 * Version: 0.1
 * Author: Surprise.com team
 * Author URI: https://surprise.com
 */


add_filter('upload_mimes', 'surprise_mime_types');

function surprise_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	$mimes['json'] = 'application/json';
	$mimes['json'] = 'text/plain';
	return $mimes;
}
