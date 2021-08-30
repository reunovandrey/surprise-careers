<?php
$context          = Timber::context();
$context['post'] = new Timber\Post();
$context['subtitle'] = __('Don’t hesitate to provide us with a referral — and receive a special bonus!');

if ( isset( $_GET['job_id'] ) && ! empty( $_GET['job_id'] ) ) {
	$context['job'] = new Timber\Post( $_GET['job_id'] );
}

Timber::render( 'page-referral.twig', $context );