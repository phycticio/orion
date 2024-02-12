<?php

/**
 * Plugin Name: Orion
 * Plugin URI: https://github.com/wp-orion
 * GitHub Plugin URI: https://github.com/wp-orion
 * Description: Let's decapitate WP.
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

require_once ORION_PATH . '/vendor/autoload.php';
\orion\actions\Orion_Initializer::start();
\orion\actions\admin\Orion_Enqueue_Scripts::init();
\orion\actions\admin\Orion_Options::init();
\orion\actions\Orion_After_Setup_Theme::init();
\orion\filters\Orion_General::init();
\orion\actions\admin\Orion_Save_Theme_Options::init();
\orion\actions\admin\Orion_Post_Types::init();
\orion\actions\admin\post_types\Orion_CPT_Fields::init();
