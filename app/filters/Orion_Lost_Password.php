<?php

namespace orion\filters;

class Orion_Lost_Password {
	public static function start() : void {
		add_filter('retrieve_password_message', self::retrieve_password_message(...), 10, 4);
	}

	public static function retrieve_password_message($message, $key, $user_login, $user_data) : string {
		$locale = get_user_locale( $user_data );
		$message = __( 'Someone has requested a password reset for the following account:', 'orion' ) . "\r\n\r\n";
		/* translators: %s: Site name. */
		$message .= sprintf( __( 'Site Name: %s' ), get_bloginfo() ) . "\r\n\r\n";
		/* translators: %s: User login. */
		$message .= sprintf( __( 'Username: %s' ), $user_login ) . "\r\n\r\n";
		$message .= __( 'If this was a mistake, ignore this email and nothing will happen.' ) . "\r\n\r\n";
		$message .= __( 'To reset your password, visit the following address:' ) . "\r\n\r\n";
		$message .= network_site_url(
			get_field('reset_password_url', 'option') .
			"/?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . '&wp_lang=' . $locale . "\r\n\r\n";

		if ( ! is_user_logged_in() ) {
			$requester_ip = $_SERVER['REMOTE_ADDR'];
			if ( $requester_ip ) {
				$message .= sprintf(
				            /* translators: %s: IP address of password reset requester. */
					            __( 'This password reset request originated from the IP address %s.' ),
					            $requester_ip
				            ) . "\r\n";
			}
		}

		return $message;
	}
}