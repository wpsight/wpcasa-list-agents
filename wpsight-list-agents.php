<?php
/*
Plugin Name: WPCasa List Agents
Plugin URI: http://wpcasa.com/addon/wpcasa-list-agents
Description: Display a list of agents using a shortocde.
Version: 1.0.0
Author: WPSight
Author URI: http://wpsight.com
Requires at least: 4.0
Tested up to: 4.3
Text Domain: wpsight-list-agents
Domain Path: /languages

	Copyright: 2015 Simon Rimkus
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

// Exit if accessed directly

if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * WPSight_List_Agents class.
 */
class WPSight_List_Agents {

	/**
	 * Constructor
	 */
	public function __construct() {

		// Define constants
		
		if ( ! defined( 'WPSIGHT_NAME' ) )
			define( 'WPSIGHT_NAME', 'WPCasa' );
		
		if ( ! defined( 'WPSIGHT_DOMAIN' ) )
			define( 'WPSIGHT_DOMAIN', 'wpcasa' );

		define( 'WPSIGHT_LIST_AGENTS_NAME', 'WPCasa List Agents' );
		define( 'WPSIGHT_LIST_AGENTS_DOMAIN', 'wpcasa-list-agents' );
		define( 'WPSIGHT_LIST_AGENTS_VERSION', '1.0.0' );
		define( 'WPSIGHT_LIST_AGENTS_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'WPSIGHT_LIST_AGENTS_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
		
		// Include functions
		include( 'wpsight-list-agents-functions.php' );
		
		// Include shortcode
		include( 'includes/class-wpsight-list-agents-shortcode.php' );
		
		// Include admin part

		if ( is_admin() ) {
			include( WPSIGHT_LIST_AGENTS_PLUGIN_DIR . '/includes/admin/class-wpsight-list-agents-admin.php' );
			$this->admin = new WPSight_List_Agents_Admin();
		}

		// Actions
		
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );

	}

	/**
	 *  Initialize the plugin when WPCasa is loaded.
	 *
	 *  @param	object	$wpsight
	 *  @return object	$wpsight->list_agents
	 */
	public static function init( $wpsight ) {
		
		if ( ! isset( $wpsight->list_agents ) )
			$wpsight->list_agents = new self();

		do_action_ref_array( 'wpsight_init_list_agents', array( &$wpsight ) );

		return $wpsight->list_agents;
	}

	/**
	 * load_plugin_textdomain()
	 *
	 * Set up localization for this plugin
	 * loading the text domain.
	 *
	 * @uses load_plugin_textdomain()
	 * @since 1.0.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'wpsight-list-agents', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * frontend_scripts()
	 *
	 * Register and enqueue scripts and css.
	 *
	 * @uses wp_enqueue_style()
	 * @since 1.0.0
	 */
	public function frontend_scripts() {
		wp_enqueue_style( 'wpsight-list-agents', WPSIGHT_LIST_AGENTS_PLUGIN_URL . '/assets/css/frontend.css' );
	}
	
}

add_action( 'wpsight_init', array( 'WPSight_List_Agents', 'init' ) );
