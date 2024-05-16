<?php

namespace orion\actions;

use orion\helpers\Common;
use orion\helpers\View;

class Orion_Login {
	public static function start(): void {
		$customize_login_page = get_option( 'customize_login_page', 'option' );
		$custom_login_url     = get_option( 'custom_login_url', 'orion' );
		if ( $customize_login_page ) {
			add_action( 'login_enqueue_scripts', self::login_enqueue_scripts( ... ) );
			add_action( 'login_headerurl', self::login_headerurl( ... ) );
		}

		if ( $custom_login_url ) {
			add_action( 'template_include', self::template_include( ... ), 1 );
			add_action( 'login_url', self::login_url( ... ) );
			add_action( 'register_url', self::register_url( ... ) );
			add_action( 'lostpassword_url', self::lostpassword_url( ... ) );
		}
	}

	public static function login_enqueue_scripts(): void {
		wp_enqueue_style( 'orion-wp-login-style-vars', ORION_URL . 'generated/css/login-vars.css' );
		$login_assets = require_once( ORION_PATH . 'dist/login.asset.php' );
		wp_enqueue_style(
			'orion-wp-login-style',
			ORION_URL . 'dist/login.css',
			[ 'orion-wp-login-style-vars' ],
			$login_assets['version']
		);
		wp_register_script(
			'orion-wp-login-scripts',
			ORION_URL . 'dist/login.js',
			null,
			$login_assets['version'],
			[ 'in_footer' => true ]
		);
	}

	public static function login_headerurl(): string {
		return home_url();
	}

	public static function template_include( $template ) {
		if ( ! get_field( 'custom_login_url', 'option' ) ) {
			return $template;
		}
		if (
			is_page( get_field( 'register_url', 'option' ) ) ||
			is_page( get_field( 'lost_password_url', 'option' ) ) ||
			is_page( get_field( 'reset_password_url', 'option' ) ) ||
			is_page( get_field( 'login_url', 'option' ) )
		) {
			self::set_action( get_page_uri() );

			return ORION_PATH . 'templates/login.php';
		}

		return $template;
	}

	public static function set_action( string $uri ): void {
		$action = 'login';
		switch ( $uri ) {
			case get_field( 'register_url', 'option' ):
				$action = 'register';
				break;
			case get_field( 'lost_password_url', 'option' ):
				$action = 'lostpassword';
				break;
			case get_field( 'reset_password_url', 'option' ):
				$action = 'rp';
				break;
		}
		$_REQUEST['action'] = $_REQUEST['action'] ?? $action;
	}

	public static function login_url( string $login_url, ?string $redirect = null, ?bool $force_reauth = false ): string {
		$login_page_path = get_field( 'login_page', 'option' );
		if ( get_field( 'custom_login_url', 'option' ) && ! empty( $login_page_path ) ) {
			$login_url = trailingslashit( site_url( $login_page_path, 'login' ) );
			if ( ! empty( $redirect ) ) {
				$login_url = add_query_arg( 'redirect_to', urlencode( $redirect ), $login_page_path );
			}
			if ( $force_reauth ) {
				$login_url = add_query_arg( 'reauth', '1', $login_url );
			}
		}

		return $login_url;
	}

	public static function register_url( string $register_url ): string {
		$register_page_path = get_field( 'register_page', 'option' );
		if ( get_field( 'custom_login_url', 'option' ) && $register_page_path ) {
			return trailingslashit( site_url( $register_page_path, 'register' ) );
		}

		return $register_url;
	}

	public static function lostpassword_url( string $lostpassword_url ): string {
		$lost_password_page = get_field( 'lost_password_url', 'option' );
		if ( get_field( 'custom_login_url', 'option' ) && $lost_password_page ) {
			return trailingslashit( site_url( $lost_password_page, 'register' ) );
		}

		return $lostpassword_url;
	}
}