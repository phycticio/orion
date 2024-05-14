<?php

/**
 * Plugin Name: Orion
 * Plugin URI: https://github.com/wp-orion
 * GitHub Plugin URI: https://github.com/wp-orion
 * Description: ACF + Elementor extension
 * Author: phycticio
 * Author URI: http://www.phycticio.com
 * Version: 0.0.1
 * Text Domain: orion
 * Domain Path: /languages/
 * Requires at least: 5.0
 * Tested up to: 6.2
 * Requires PHP: 7.1
 * License: GPL-3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 */

define( 'ORION_URL', plugin_dir_url( __FILE__ ) );
define( 'ORION_PATH', plugin_dir_path( __FILE__ ) );
define( 'ORION_VER', filemtime( ORION_PATH . '/dist/orion.css' ) );
const ORION_META_KEY_PAGES_NAME  = 'session-page';
const ORION_SETTINGS_OBJECT_ID   = 914;
const ORION_GOOGLE_MAPS_API_KEY  = 'AIzaSyAncEM3NM9bgoV2vPCghVsC0Zj2wSQJ6PA';
const ORION_GOOGLE_FONTS_API_KEY = 'AIzaSyBDjBu0YICdC1CxOAu5DTizv3gzzTLPs6o';

require_once ORION_PATH . '/vendor/autoload.php';

if ( function_exists( 'acf_add_local_field_group' ) ) {
	\orion\actions\Orion_Initializer::start();
}
