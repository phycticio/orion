<?php

namespace orion\actions;

use orion\actions\admin\Orion_Dashboard;
use orion\actions\admin\Orion_Enqueue_Scripts;
use orion\actions\admin\Orion_Save_Theme_Options;
use orion\actions\elementor\Orion_Elementor;
use orion\actions\Orion_Register as Orion_Register_Action;
use orion\filters\admin\Orion_ACF;
use orion\filters\Orion_General;
use orion\filters\Orion_Login as Orion_Login_Filter;
use orion\filters\Orion_Lost_Password;
use orion\filters\Orion_Register;
use orion\option_pages\Orion_Email_Marketing_Settings;
use orion\option_pages\Orion_Login_Settings;
use orion\option_pages\Orion_Registration_Fields;
use orion\option_pages\Orion_Settings_Main_Page;

class Orion_Initializer {
	public static function start(): void {
		add_action( 'init', self::init( ... ) );
		add_action( 'plugins_loaded', self::plugins_loaded( ... ) );

		$options = get_fields('options');
		if(is_array($options))
            extract($options);
        if (isset($authenticated_users_only) && !!$authenticated_users_only === true)
            Orion_Force_Login::start();

		Orion_Dashboard::start();
        Orion_Login::start();
        Orion_Login_Filter::start();
		Orion_Register::start();
		Orion_Register_Action::start();
		Orion_Lost_Password::start();
		Orion_Cron::start();

        if(WP_ENVIRONMENT_TYPE === 'production') {
	        Orion_Settings_Main_Page::start();
	        Orion_Login_Settings::start();
			Orion_Registration_Fields::start();
	        Orion_Email_Marketing_Settings::start();
        }
        Orion_Enqueue_Scripts::start();
        Orion_ACF::start();
        Orion_General::start();
        Orion_Save_Theme_Options::start();
        Orion_Elementor::start();
	}

	public static function init(): void {
		$heartbeat = get_option('heartbeat', 'off');
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