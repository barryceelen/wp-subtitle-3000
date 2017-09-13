<?php
/**
 * Main plugin file
 *
 * @package    WordPress
 * @subpackage Subtitle_3000
 * @author     Barry Ceelen
 * @license    GPL-3.0+
 * @link       https://github.com/barryceelen/wp-subtitle-3000
 * @copyright  2017 Barry Ceelen
 *
 * Plugin Name:       Subtitle 3000
 * Plugin URI:        https://github.com/barryceelen/wp-subtitle-3000
 * Description:       Add a subtitle input field to the post edit screen.
 * Version:           1.0.1
 * Author:            Barry Ceelen
 * Author URI:        https://github.com/barryceelen
 * Text Domain:       subtitle-3000
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/barryceelen/wp-subtitle-3000
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( is_admin() ) {

	include( 'class-subtitle-3000-admin.php' );

	/**
	 * Load plugin textdomain.
	 *
	 * @since 1.0.1
	 */
	function subtitle_3000_load_textdomain() {

		if ( false !== strpos( __FILE__, basename( WPMU_PLUGIN_DIR ) ) ) {
			load_muplugin_textdomain( 'subtitle-3000', 'subtitle-3000/languages' );
		} else {
			load_plugin_textdomain( 'subtitle-3000', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}
	}

	add_action( 'plugins_loaded', 'subtitle_3000_load_textdomain' );
}
