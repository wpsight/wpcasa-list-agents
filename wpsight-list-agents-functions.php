<?php
/**
 * wpsight_get_list_agents()
 *
 * Echo formatted list of agents
 * with the corresponding templates.
 *
 * @param array $args Array of arguments for WP_User_Query()
 * @uses wpsight_get_list_agents()
 * @uses wpsight_get_template()
 *
 * @since 1.0.0
 */

function wpsight_list_agents( $args = array() ) {
	
	// Get user query
	$user_query = wpsight_get_list_agents( $args );
		
	// If we have users, loop through them

	if ( ! empty( $user_query->results ) ) {

		foreach ( $user_query->results as $user )			
			wpsight_get_template( 'list-agent.php', array( 'user' => $user, 'args' => $args ), WPSIGHT_LIST_AGENTS_PLUGIN_DIR . '/templates' );
		
		// Include pagination
		wpsight_pagination( $user_query->total_users, array( 'total' => ceil( $user_query->get_total() / $args['number'] ) ) );

	} else {
		
		// If no users, load other template
		wpsight_get_template( 'list-agent-no.php', false, WPSIGHT_LIST_AGENTS_PLUGIN_DIR . '/templates' );

	}
	
}

/**
 * wpsight_get_list_agents()
 *
 * Get list of agents without the ones with the
 * exclude option on the profile page activated.
 *
 * @param array $args Array of arguments for WP_User_Query()
 * @return object WP_User_Query()
 *
 * @since 1.0.0
 */

function wpsight_get_list_agents( $args = array() ) {
	
	// Get agents to be excluded
	
	$user_query_exclude = new WP_User_Query( array( 'meta_key' => 'agent_exclude', 'meta_value' => '1' ) );
	
	$exclude = array();
	
	foreach( $user_query_exclude->results as $user )
		if( ! isset( $args['include'] ) || ! in_array( $user->ID, $args['include'] ) )
			$exclude[] = $user->ID;
	
	if( isset( $args['exclude'] ) ) {
		$args['exclude'] = array_merge( $args['exclude'], $exclude );
	} else {
		$args['exclude'] = $exclude;
	}
	
	// Set offset for correct pagination

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;	
	$args['number'] = isset( $args['number'] ) ? intval( $args['number'] ) : 10;
	$args['offset'] = $args['number'] * ( $paged - 1 );
	
	// Apply filter and return query object
	return new WP_User_Query( apply_filters( 'wpsight_get_list_agents_args', $args ) );

}
