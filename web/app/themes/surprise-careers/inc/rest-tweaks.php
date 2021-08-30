<?php

add_filter( 'rest_query_vars', function ( $valid_vars ) {
	return array_merge( $valid_vars, array( 'team', 'location', 'tax_query' ) );
} );

add_filter( 'rest_career_query', function ( $args, $request ) {
	$team     = $request->get_param( 'team' );
	$location = $request->get_param( 'location' );

	$tax_query = [ 'relation' => 'AND' ];

	if ( ! empty( $team ) ) {
		$tax_query[] = [
			'taxonomy' => 'category',
			'terms'    => $team
		];
	}
	if ( ! empty( $location ) ) {
		$tax_query[] = [
			'taxonomy' => 'locations',
			'terms'    => $location
		];
	}

	$args['tax_query'] = $tax_query;

	return $args;
}, 10, 2 );

add_action( 'rest_api_init', 'create_api_careers_fields' );

function create_api_careers_fields() {
	register_rest_field( 'career', 'team', array(
			'get_callback' => function ( $object ) {
				return get_the_category( $object['id'] );
			},
			'schema'       => null,
		)
	);
	register_rest_field( 'career', 'location', array(
			'get_callback' => function ( $object ) {
				return get_the_terms( $object['id'], 'locations' );
			},
			'schema'       => null,
		)
	);
	register_rest_field( 'career', 'skills', array(
			'get_callback' => function ( $object ) {
				$tech_stack = get_field( 'tech_stack', $object['id'] );
				$skills     = [];
				foreach ( $tech_stack as $skill ) {
					$skills[] = [
						'name' => $skill['technology']->name,
						'slug' => $skill['technology']->slug,
						'icon' => get_field( 'icon', 'term_' . $skill['technology']->term_id )
					];
				}

				return $skills;
			},
			'schema'       => null,
		)
	);
}