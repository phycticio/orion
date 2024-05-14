<?php

namespace orion\filters;

use WP_Error;

class Orion_Force_Login {
	public static function init() : void {
		add_filter( 'rest_authentication_errors', Orion_Force_Login::force_login_rest_access(...), 99 );
		add_filter( 'login_url', Orion_Force_Login::login_url(...), 10, 3 );
		add_filter( 'register_url', Orion_Force_Login::register_url(...), 10, 2 );
	}

	/**
	 * @param $result
	 *
	 * @return mixed|WP_Error
	 */
	public static function force_login_rest_access( $result ) : mixed {
		if ( null === $result && ! is_user_logged_in() ) {
			return new WP_Error(
				'rest_unauthorized',
				__( 'Only authenticated users can access the REST API.', 'orion' ),
				array( 'status' => rest_authorization_required_code() )
			);
		}
		return $result;
	}

	/**
	 * @param $login_url
	 * @param $redirect
	 * @param $force_re_auth
	 *
	 * @return string
	 */
	public static function login_url($login_url, $redirect, $force_re_auth) : string {
		$login_page_url = get_field('login_url', 'option');
		if($login_page_url){
			return "{$login_page_url}?redirect_to={$redirect}";
		}
		return "{$login_url}?redirect_to={$redirect}";
	}

	/**
	 * @param $register_url
	 *
	 * @return string
	 */
	public static function register_url($register_url) : string {
		$register_page_url = get_field('registration_url', 'option');
		if($register_page_url){
			return $register_page_url;
		}
		return $register_url;
	}
}