<?php
/*
Plugin Name: Checkbox for Taxonomies
Plugin URI: http://wordpress.org/plugins/checkbox-for-taxonomies
Description: Use checkbox for any taxonomy.
Version: 1.1
Text Domain: checkbox-for-taxonomies
Author: Kathy Darling, Ghaem Omidi
Author URI: http://wordpress.org/plugins/checkbox-for-taxonomies
License: GPL2

Copyright 2015  Kathy Darling  (email: kathy.darling@gmail.com) and Ghaem Omidi (ghaemomidi@yahoo.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

/*
This is a plugin implementation of the wp.tuts+ tutorial: http://wp.tutsplus.com/tutorials/creative-coding/how-to-use-radio-buttons-with-taxonomies/ by Stephen Harris
Stephen Harris http://profiles.wordpress.org/stephenh1988/

To use this plugin, just activate it and go to the settings page.  Then Check the taxonomies that you'd like to switch to using checkbox and save the settings.
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if ( ! class_exists( 'checkbox_s_for_Taxonomies' ) ) :

class checkbox_s_for_Taxonomies {

	/**
	 * @var checkbox_s_for_Taxonomies The single instance of the class
	 * @since 1.6.0
	 */
	protected static $_instance = null;

	/**
	 * @var version
	 * @since 1.7.0
	 */
	static $version = '1.7.0';

	/**
	 * @var plugin options
	 * @since 1.7.0
	 */
	public $options = array();

	/**
	 * @var taxonomies WordPress_checkbox_Taxonomy instances as an array, keyed on taxonomy name.
	 * @since 1.7.0
	 */
	public $taxonomies = array();

	/**
	 * Main checkbox_s_for_Taxonomies Instance
	 *
	 * Ensures only one instance of checkbox_s_for_Taxonomies is loaded or can be loaded.
	 *
	 * @since 1.6.0
	 * @static
	 * @see checkbox_s_for_Taxonomies()
	 * @return checkbox_s_for_Taxonomies - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.6.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' , 'checkbox-for-taxonomies' ), '1.6' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.6.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' , 'checkbox-for-taxonomies' ), '1.6' );
	}

	/**
	 * checkbox_s_for_Taxonomies Constructor.
	 * @access public
	 * @return checkbox_s_for_Taxonomies
	 * @since  1.0
	 */
	public function __construct(){

			// Include required files
			include_once( 'inc/class.WordPress_checkbox_Taxonomy.php' );
			include_once( 'inc/class.Walker_Category_checkbox.php' );

			$this->options = get_option( 'checkbox_for_taxonomies_options', true );

			// Set-up Action and Filter Hooks
			register_uninstall_hook( __FILE__, array( __CLASS__, 'delete_plugin_options' ) );

			// load plugin text domain for translations
			add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );

			// launch each taxonomy class when tax is registered
			add_action( 'registered_taxonomy', array( $this, 'launch' ) );

			// register admin settings
			add_action( 'admin_init', array( $this, 'admin_init' ) );

			// add plugin options page
			add_action( 'admin_menu', array( $this, 'add_options_page' ) );

			// Load admin scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_script' ) );

			// add settings link to plugins page
			add_filter( 'plugin_action_links', array( $this, 'add_action_links' ), 10, 2 );

			add_filter( 'mlp_mutually_exclusive_taxonomies', array( $this, 'multilingualpress_support' ) );
	}


	/**
	 * Delete options table entries ONLY when plugin deactivated AND deleted
	 * @access public
	 * @return void
	 * @since  1.0
	 */
	public function delete_plugin_options() {
		$options = get_option( 'checkbox_for_taxonomies_options', true );
		if( isset( $options['delete'] ) && $options['delete'] ) delete_option( 'checkbox_for_taxonomies_options' );
	}


	/**
	 * Make plugin translation-ready
	 * @access public
	 * @return void
	 * @since  1.0
	 */
	public function load_text_domain() {
		load_plugin_textdomain( "checkbox-for-taxonomies", false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * For each taxonomy that we are converting to checkbox, store in taxonomies class property, ex: $this->taxonomies[categories]
	 * @access public
	 * @return object
	 * @since  1.0
	 */
	public function launch( $taxonomy ){
		if( isset( $this->options['taxonomies'] ) && in_array( $taxonomy, (array) $this->options['taxonomies'] ) ) {
			$this->taxonomies[$taxonomy] = new WordPress_checkbox_Taxonomy( $taxonomy );
		}
	}

	// ------------------------------------------------------------------------------
	// Admin options
	// ------------------------------------------------------------------------------

	/**
	 * Whitelist plugin options
	 * @access public
	 * @return void
	 * @since  1.0
	 */
	public function admin_init(){
		register_setting( 'checkbox_for_taxonomies_options', 'checkbox_for_taxonomies_options', array( $this,'validate_options' ) );
	}


	/**
	 * Add plugin's options page
	 * @access public
	 * @return void
	 * @since  1.0
	 */
	public function add_options_page() {
		add_options_page(__( 'Checkbox for Taxonomies Options Page',"checkbox-for-taxonomies" ), __( 'Checkbox for Taxonomies', "checkbox-for-taxonomies" ), 'manage_options', 'checkbox-for-taxonomies', array( $this,'render_form' ) );
	}

	/**
	 * Render the Plugin options form
	 * @access public
	 * @return void
	 * @since  1.0
	 */
	public function render_form(){
		include( 'inc/plugin-options.php' );
	}

	/**
	 * Sanitize and validate options
	 * @access public
	 * @param  array $input
	 * @return array
	 * @since  1.0
	 */
	public function validate_options( $input ){

		$clean = array();

		//probably overkill, but make sure that the taxonomy actually exists and is one we're cool with modifying
		$args = array(
			'public'   => true,
			'show_ui' => true
		);

		$taxonomies = get_taxonomies( $args );

		if( isset( $input['taxonomies'] ) ) foreach ( $input['taxonomies'] as $tax ){
			if( in_array( $tax,$taxonomies ) ) $clean['taxonomies'][] = $tax;
		}

		$clean['delete'] =  isset( $input['delete'] ) && $input['delete'] ? 1 : 0 ;  //checkbox

		return $clean;
	}

	/**
	 * Enqueue Scripts
	 * @access public
	 * @return void
	 * @since  1.0
	 */
	public function admin_script( $hook ){
		if( in_array( $hook, array( 'edit.php', 'post.php', 'post-new.php' ) ) ){
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
			wp_enqueue_script( 'checkboxtax', plugins_url( 'js/checkboxtax' . $suffix . '.js', __FILE__ ), array( 'jquery', 'inline-edit-post' ), self::$version, true );
		}
	}

	/**
	 * Display a Settings link on the main Plugins page
	 * @access public
	 * @param  array $links
	 * @param  string $file
	 * @return array
	 * @since  1.0
	 */
	public function add_action_links( $links, $file ) {

		if ( $file == plugin_basename( __FILE__ ) ) {
			$plugin_link = '<a href="'.admin_url( 'options-general.php?page=checkbox-for-taxonomies' ) . '">' . __( 'Settings' , 'checkbox-for-taxonomies' ) . '</a>';
			// make the 'Settings' link appear first
			array_unshift( $links, $plugin_link );
		}

		return $links;
	}


	// ------------------------------------------------------------------------------
	// Helper Functions
	// ------------------------------------------------------------------------------

	/**
	 * Get all taxonomies - for plugin options checklist
	 * @access public
	 * @return array
	 * @since  1.7
	 */
	function get_all_taxonomies() {

		$args = array (
			'public'   => true,
			'show_ui'  => true,
			'_builtin' => true
		);

		$defaults = get_taxonomies( $args, 'objects' );

		$args['_builtin'] = false;

		$custom = get_taxonomies( $args, 'objects' );

		$taxonomies = apply_filters( 'checkbox_s_for_taxonomies_taxonomies', array_merge( $defaults, $custom ) );

		ksort( $taxonomies );

		return $taxonomies;
	}

	/**
	 * Make sure Multilingual Press shows the correct user interface.
	 *
	 * This method is called after switch_to_blog(), so we have to fetch the
	 * options separately.
	 *
	 * @wp-hook mlp_mutually_exclusive_taxonomies
	 * @param array $taxonomies
	 * @return array
	 */
	public function multilingualpress_support( Array $taxonomies ) {

		$remote_options = get_option( 'checkbox_for_taxonomies_options', array() );

		if ( empty ( $remote_options['taxonomies'] ) )
			return $taxonomies;

		$all_taxonomies = array_merge( (array) $remote_options['taxonomies'], $taxonomies );

		return array_unique( $all_taxonomies );
	}


} // end class
endif;


/**
 * Launch the whole plugin
 * Returns the main instance of WC to prevent the need to use globals.
 *
 * @since  1.6
 * @return checkbox_s_for_Taxonomies
 */
function checkbox_s_for_Taxonomies() {
	return checkbox_s_for_Taxonomies::instance();
}

// Global for backwards compatibility.
$GLOBALS['checkbox_s_for_Taxonomies'] = checkbox_s_for_Taxonomies();

