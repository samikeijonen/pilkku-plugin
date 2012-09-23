<?php
/**
 * Plugin Name: Pilkku Plugin
 * Plugin URI: http://foxnet.fi/en
 * Description: Add stuff what we need in school magazine.
 * Version: 0.2
 * Author: Sami Keijonen
 * Author URI: http://foxnet.fi/en
 * Contributors: samikeijonen
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume 
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package PilkkuPlugin
 * @version 0.2
 * @author Sami Keijonen <sami.keijonen@foxnet.fi>
 * @copyright Copyright (c) 2012, Sami Keijonen
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

class Pilkku_Plugin {

	/**
	 * PHP5 constructor method.
	 *
	 * @since 0.2.0
	 */
	public function __construct() {

		/* Set the constants needed by the plugin. */
		add_action( 'plugins_loaded', array( &$this, 'constants' ), 1 );

		/* Internationalize the text strings used. */
		add_action( 'plugins_loaded', array( &$this, 'i18n' ), 2 );

		/* Load the functions files. */
		add_action( 'plugins_loaded', array( &$this, 'includes' ), 3 );

		/* Register activation hook. */
		//register_activation_hook( __FILE__, array( &$this, 'activation' ) );
		
	}

	/**
	 * Defines constants used by the plugin.
	 *
	 * @since 0.2.0
	 */
	public function constants() {

		/* Set constant path to the plugin directory. */
		define( 'PILKKU_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		/* Set the constant path to the includes directory. */
		define( 'PILKKU_PLUGIN_INCLUDES', PILKKU_PLUGIN_DIR . trailingslashit( 'includes' ) );

	}
	
	/**
	 * Load the translation of the plugin.
	 *
	 * @since 0.2.0
	 */
	public function i18n() {

		/* Load the translation of the plugin. */
		load_plugin_textdomain( 'pilkku-plugin', false, 'pilkku-plugin/languages' );
		
	}
	
	/**
	 * Loads the initial files needed by the plugin.
	 *
	 * @since 0.2.0
	 */
	public function includes() {

		require_once( PILKKU_PLUGIN_INCLUDES . 'functions.php' );
		require_once( PILKKU_PLUGIN_INCLUDES . 'post-types.php' );
		
	}

}

new Pilkku_Plugin();

?>