<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * WPSight_List_Agents_Admin class
 */
class WPSight_List_Agents_Admin {

	/**
	 *	Constructor
	 */
	public function __construct() {

		add_action( 'show_user_profile', array( $this, 'profile_agent_exclude' ) );
		add_action( 'edit_user_profile', array( $this, 'profile_agent_exclude' ) );
		
		add_action( 'personal_options_update', array( $this, 'profile_agent_exclude_save' ) );
		add_action( 'edit_user_profile_update', array( $this, 'profile_agent_exclude_save' ) );
		
		// Add addon license to licenses page
		add_filter( 'wpsight_licenses', array( $this, 'license' ) );
		
		// Add plugin updater
		add_action( 'admin_init', array( $this, 'update' ), 0 );

	}
	
	/**
	 *	profile_agent_exclude()
	 *	
	 *	Add exclude agent from lists option to profile
	 *	
	 *	@param	object	$user	The WP_User object of the user being edited
	 *	@uses	current_user_can()
	 *	@uses	get_the_author_meta()
	 *	
	 *	@since 1.0.0
	 */
	public function profile_agent_exclude( $user ) {
		
		if ( ! current_user_can( 'listing_admin' ) && ! current_user_can( 'administrator' ) )
	        return false; ?>
	
	    <table class="form-table">
	        <tr>
	            <th><label for="agent_exclude"><?php _e( 'Agent Lists', 'wpcasa-list-agents' ); ?></label></th>
	            <td>
	                <input type="checkbox" value="1" name="agent_exclude" id="agent_exclude" style="margin-right:5px" <?php checked( get_the_author_meta( 'agent_exclude', $user->ID ), 1 ); ?>> <?php _e( 'Hide this user from agent lists', 'wpcasa-list-agents' ); ?>
	            </td>
	        </tr>
	    </table><?php
	    
	}
	
	/**
	 *	profile_agent_exclude_save()
	 *	
	 *	Save exclude agent option on profile pages
	 *	
	 *	@param	interger	$user_id	The user ID of the user being edited
	 *	@uses	current_user_can()
	 *	@uses	update_user_meta()
	 *	
	 *	@since 1.0.0
	 */
	public function profile_agent_exclude_save( $user_id ) {
	
	    if ( ! current_user_can( 'listing_admin' ) && ! current_user_can( 'administrator' ) )
	        return false;
	        
		$_POST['agent_exclude'] = isset( $_POST['agent_exclude'] ) ? $_POST['agent_exclude'] : false;
	
	    update_user_meta( $user_id, 'agent_exclude', $_POST['agent_exclude'] );
	
	}
	
	/**
	 *	license()
	 *	
	 *	Add addon license to licenses page
	 *	
	 *	@return	array	$options_licenses
	 *	
	 *	@since 1.0.0
	 */
	public static function license( $licenses ) {
		
		$licenses['list_agents'] = array(
			'name' => WPSIGHT_LIST_AGENTS_NAME,
			'desc' => sprintf( __( 'For premium support and seamless updates for %s please activate your license.', 'wpcasa-list-agents' ), WPSIGHT_LIST_AGENTS_NAME ),
			'id'   => wpsight_underscores( WPSIGHT_LIST_AGENTS_DOMAIN )
		);
		
		return $licenses;
	
	}
	
	/**
	 *	update()
	 *	
	 *	Set up EDD plugin updater.
	 *	
	 *	@uses	class_exists()
	 *	@uses	get_option()
	 *	@uses	wpsight_underscores()
	 *	
	 *	@since 1.0.0
	 */
	function update() {
		
		if( ! class_exists( 'EDD_SL_Plugin_Updater' ) )
			return;

		// Get license option
		$licenses = get_option( 'wpsight_licenses' );		
		$key = wpsight_underscores( WPSIGHT_LIST_AGENTS_DOMAIN );
	
		// Setup the updater
		$edd_updater = new EDD_SL_Plugin_Updater( WPSIGHT_SHOP_URL, WPSIGHT_LIST_AGENTS_PLUGIN_DIR . '/' . WPSIGHT_LIST_AGENTS_DOMAIN . '.php', array(
				'version' 	=> WPSIGHT_LIST_AGENTS_VERSION,
				'license' 	=> isset( $licenses[ $key ] ) ? trim( $licenses[ $key ] ) : false,
				'item_name' => WPSIGHT_LIST_AGENTS_NAME,
				'author' 	=> WPSIGHT_AUTHOR
			)
		);
	
	}

}
