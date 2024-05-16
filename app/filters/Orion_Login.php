<?php

namespace orion\filters;

class Orion_Login {
	const GOOGLE_FONT_DB_EXPIRATION_TIME = 60 * 60 * 24;

	public static function start(): void {
		add_filter( 'login_title', self::login_title( ... ) );
		add_filter( 'login_form_defaults', self::login_form_defaults( ... ) );
		add_filter( 'acf/prepare_field/name=font-family', self::acf_prepare_field_font_family( ... ) );
		add_filter( 'login_errors', self::login_errors( ... ) );
		add_filter( 'gettext', self::gettext( ... ), 10, 3 );
	}

	public static function login_title(): string {
		return get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' );
	}

	public static function login_form_defaults( array $defaults ): array {
		$defaults['label_username'] = get_field( 'label_username', 'option' );
		$defaults['label_password'] = get_field( 'label_password', 'option' );
		$defaults['label_remember'] = get_field( 'label_remember', 'option' );
		$defaults['label_log_in']   = get_field( 'label_log_in', 'option' );

		return $defaults;
	}

	public static function acf_prepare_field_font_family( $field ) {
		$is_new_file    = false;
		$font_data_file = ORION_PATH . 'generated/data/google-fonts.json';
		if ( ! is_file( $font_data_file ) ) {
			$is_new_file = true;
			touch( $font_data_file );
		}

		$difference = time() - filemtime( $font_data_file );

		if ( $is_new_file ||
		     $difference > self::GOOGLE_FONT_DB_EXPIRATION_TIME ) {
			$google_fonts_result = wp_remote_get(
				'https://webfonts.googleapis.com/v1/webfonts?' .
				http_build_query( [ 'key' => ORION_GOOGLE_FONTS_API_KEY ] )
			);
			$google_fonts_body   = wp_remote_retrieve_body( $google_fonts_result );
			$google_fonts_json   = json_decode( $google_fonts_body );
			file_put_contents( $font_data_file, $google_fonts_body );
		} else {
			$google_fonts_json = json_decode( file_get_contents( $font_data_file ) );
		}

		$choices               = &$field['choices'];
		$choices['default']    = __( 'Default font family', 'orion' );
		$default_font_families = [
			'serif'      => 'Serif',
			'sans-serif' => 'Sans serif',
			'monospace'  => 'Monospace',
			'cursive'    => 'Cursive',
			'fantasy'    => 'Fantasy',
			'system-ui'  => 'System UI',
		];
		foreach ( $default_font_families as $key => $default_font_family ) {
			$choices[ $key ] = $default_font_family;
		}
		$choices['-'] = 'Google fonts';
		if ( isset( $google_fonts_json->items ) && count( $google_fonts_json->items ) > 0 ) {
			foreach ( $google_fonts_json->items as $item ) {
				$choices[ _wp_to_kebab_case( $item->family ) ] = $item->family;
			}
		}

		return $field;
	}

	public static function login_errors( string $error ): ?string {
		if ( ! get_field( 'use_generic_error_message', 'option' ) ) {
			return $error;
		}

		global $errors;
		$error_codes = $errors->get_error_codes();
		if ( in_array( 'invalid_username', $error_codes ) || in_array( 'incorrect_password', $error_codes ) ) {
			return '<strong style="font-weight: bold;">' . __( 'Error', 'orion' ) . '</strong>: ' . get_field( 'generic_error_message', 'option' );
		}

		return $error;
	}

	public static function gettext( string $translation, string $text, string $domain ) {
		if ( ! get_field( 'customize_labels', 'option' ) && ! is_login() ) {
			return $translation;
		}

		$switcher = _wp_to_kebab_case( $text );
		switch ( $switcher ) {
			case 'username-or-email-address':
				$translation = ! empty( get_field( 'label_username', 'option' ) ) ?
					get_field( 'label_username', 'option' ) : $translation;
				break;
			case 'password':
				$translation = ! empty( get_field( 'label_password', 'option' ) ) ?
					get_field( 'label_password', 'option' ) : $translation;
				break;
			case 'remember-me':
				$translation = ! empty( get_field( 'label_remember', 'option' ) ) ?
					get_field( 'label_remember', 'option' ) : $translation;
				break;
			case 'log-in':
				$translation = ! empty( get_field( 'label_login_link', 'option' ) ) ?
					get_field( 'label_login_link', 'option' ) : $translation;
				break;
			case 'register':
				$translation = ! empty( get_field( 'label_register_link', 'option' ) ) ?
					get_field( 'label_register_link', 'option' ) : $translation;
				break;
			case 'lost-your-password':
				$translation = ! empty( get_field( 'label_forgot_password_link', 'option' ) ) ?
					get_field( 'label_forgot_password_link', 'option' ) : $translation;
				break;
			case 'register-for-this-site':
				$translation = ! empty( get_field( 'registration_message', 'option' ) ) ?
					get_field( 'registration_message', 'option' ) : $translation;
				break;
			case 'registration-confirmation-will-be-emailed-to-you':
				$translation = ! empty( get_field( 'registration_confirmation', 'option' ) ) ?
					get_field( 'registration_confirmation', 'option' ) : $translation;
				break;
			case 'get-new-password':
				$translation = ! empty( get_field( 'label_get_new_password', 'option' ) ) ?
					get_field( 'label_get_new_password', 'option' ) : $translation;
				break;
			case 'please-enter-your-username-or-email-address-you-will-receive-an-email-message-with-instructions-on-how-to-reset-your-password':
				$translation = ! empty( get_field( 'forgot_password_message', 'option' ) ) ?
					get_field( 'forgot_password_message', 'option' ) : $translation;
				break;
		}

		return $translation;
	}
}