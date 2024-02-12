<?php

namespace orion\actions;

use orion\helpers\Common;

class Orion_Initializer {
	public static function start(): void {
		add_action( 'init', self::init( ... ) );
		add_action( 'plugins_loaded', self::plugins_loaded( ... ) );
	}

	public static function init(): void {
		$heartbeat = carbon_get_theme_option( 'orion_heartbeat_status' );
		if ( $heartbeat === 'off' ) {
			wp_deregister_script( 'heartbeat' );
		}
	}

	public static function plugins_loaded(): void {
		load_plugin_textdomain( 'orion', false, ORION_PATH . 'languages' );

		$revisions = get_option( '_orion_revisions_amount' );
		if ( $revisions && ! defined( 'WP_POST_REVISIONS' ) ) {
			define( 'WP_POST_REVISIONS', $revisions );
		}
	}
}