<?php

namespace orion\actions;

class Orion_Force_Login {
	/**
	 * @return void
	 */
	public static function start() : void {
		add_action( 'template_redirect', Orion_Force_Login::force_login(...) );
	}

	/**
	 * @return void
	 */
	public static function force_login() : void {
		// Exceptions for AJAX, Cron, or WP-CLI requests
		if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( defined( 'DOING_CRON' ) && DOING_CRON ) || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
			return;
		}

		// Bail if the current visitor is a logged-in user, unless Multisite is enabled
		if ( is_user_logged_in() && ! is_multisite() ) {
			return;
		}

		// Get visited URL
		$schema = isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ? 'https://' : 'http://';
		$url = $schema . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

		// Bail if visiting the login URL. Fix for custom login URLs
		if ( preg_replace( '/\?.*/', '', wp_login_url() ) === preg_replace( '/\?.*/', '', $url ) ) {
			return;
		}

		$login_url = trailingslashit(site_url(get_field('login_url', 'option')));
		$register_url = trailingslashit(site_url(get_field('register_url', 'option')));
		$forgot_url = trailingslashit(site_url(get_field('lost_password_url', 'option')));
		$reset_url = trailingslashit(site_url(get_field('reset_password_url', 'option')));

		/**
		 * Whitelist filter.
		 *
		 * @since 3.0.0
		 * @deprecated 5.5.0 Use {@see 'force_login_bypass'} instead.
		 *
		 * @param $empty array An array of absolute URLs.
		 */
		$allowed_array = [$register_url, $forgot_url, $reset_url, $login_url];
		$allowed = apply_filters_deprecated( 'force_login_whitelist', [ $allowed_array ], '5.5.0', 'force_login_bypass' );
		$clear_url = str_replace("?{$_SERVER['QUERY_STRING']}", '', $url);
		/**
		 * Bypass filter.
		 *
		 * @since 5.0.0
		 * @since 5.2.0 Added the `$url` parameter.
		 *
		 * @param bool $is_in_array Whether to disable Force Login. Default false.
		 * @param string $url The visited URL.
		 */
		$bypass = apply_filters( 'force_login_bypass', in_array( $url, $allowed ) || in_array($clear_url, $allowed ), $url );

		// Bail if bypass is enabled
		if ( $bypass ) {
			return;
		}

		// Only allow Multisite users access to their assigned sites
		if ( is_multisite() && is_user_logged_in() ) {
			if ( ! is_user_member_of_blog() && ! current_user_can( 'setup_network' ) ) {
				$message = apply_filters( 'force_login_multisite_message', __( "You're not authorized to access this site.", 'wp-force-login' ), $url );
				wp_die( $message, get_option( 'blogname' ) . ' &rsaquo; ' . __( 'Error', 'wp-force-login' ) );
			}
			return;
		}

		// Determine redirect URL
		$redirect_url = apply_filters( 'force_login_redirect', $url );

		// Set the headers to prevent caching
		nocache_headers();

		// Redirect unauthorized visitors
		wp_safe_redirect( wp_login_url( $redirect_url ) );
		exit;
	}
}