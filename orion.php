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

const ORION_VER = 1;
define('ORION_URL', plugin_dir_url(__FILE__));
define('ORION_PATH', plugin_dir_path(__FILE__));

require_once ORION_PATH . '/vendor/autoload.php';
foreach(glob(__DIR__ . "/app/*.php") as $action_file) {
    if(is_file($action_file))
        require_once $action_file;
}