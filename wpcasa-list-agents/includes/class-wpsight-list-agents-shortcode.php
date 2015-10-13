<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

class WPSight_List_Agents_Shortcode {

	/**
	 * __construct()
	 *
	 * @access public
	 */
	public function __construct() {		
		add_shortcode( 'wpsight_list_agents', array( $this, 'shortcode_list_agents' ) );
	}
	
	/**
	 * shortcode_list_agents()
	 *
	 * Display list of agents.
	 *
	 * @param array $atts Shortcode attributes
	 * @uses wp_kses_allowed_html()
	 *
	 * @return string $output Entire shortcode output
	 *
	 * @since 1.0.0
	 */
	public function shortcode_list_agents( $atts ) {
		
		// Define defaults
        
        $defaults = array(
            'nr'			=> 10,
            'orderby'		=> 'ID',
            'order'			=> 'ASC',
            'include'		=> '',
            'exclude'		=> '',
            'show_image'	=> 'true',
            'show_phone'	=> 'true',
            'show_links'	=> 'true',
            'show_archive'	=> 'true',
            'before'		=> '',
            'after'			=> '',
            'wrap'			=> 'div'
        );
        
        // Merge shortcodes atts with defaults
        $args = shortcode_atts( $defaults, $atts, 'wpsight_list_agents' );
        
        // Make sure number is a number
        $args['number'] = intval( $args['nr'] );
        
        // Convert include comma-separated list in array
        $args['include'] = ! empty( $args['include'] ) ? explode( ',', $args['include'] ) : null;
        
        // Convert exclude comma-separated list in array
        $args['exclude'] = ! empty( $args['exclude'] ) ? explode( ',', $args['exclude'] ) : null;
        
        // Convert strings to bool
        
        $args['show_image']		= $args['show_image'] === 'true' ? true : false;
        $args['show_phone']		= $args['show_phone'] === 'true' ? true : false;
        $args['show_links']		= $args['show_links'] === 'true' ? true : false;
        $args['show_archive']	= $args['show_archive'] === 'true' ? true : false;
		
		ob_start();
		
		wpsight_list_agents( $args );
        
        $output = sprintf( '%1$s%3$s%2$s', wp_kses_post( $args['before'] ), wp_kses_post( $args['after'] ), ob_get_clean() );
	
		// Optionally wrap shortcode in HTML tags
		
		if( ! empty( $args['wrap'] ) && $args['wrap'] != 'false' )
			$output = sprintf( '<%2$s class="wpsight-list-agents-sc">%1$s</%2$s>', $output, tag_escape( $args['wrap'] ) );
		
		return apply_filters( 'wpsight_shortcode_list_agents', $output, $atts );

	}

}

new WPSight_List_Agents_Shortcode();
