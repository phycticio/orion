<?php

namespace orion\filters;

use WP_Error;

class Orion_Register {
	public static function start(): void {
		add_filter( 'registration_errors', self::registration_errors( ... ), 10, 3 );
	}

	public static function registration_errors(
		WP_Error $errors,
		string $sanitized_user_login,
		string $user_email
	): WP_Error {
		$registration_fields = get_field( 'registration_custom_fields', ORION_SETTINGS_OBJECT_ID );
		if ( ! $registration_fields ) {
			return $errors;
		}

		if ( ! empty( $_POST['orion_registration_fields'] ) ) {
			$post = array_map( function ( $item ) {
				return sanitize_text_field( $item );
			}, $_POST['orion_registration_fields'] );
		}

		foreach ( $registration_fields as $registration_field ) {
			$name            = $registration_field['registration_custom_field_name'];
			$validation_text = $registration_field['registration_custom_field_required_validation_text'] ??
			                   'The <strong>%s</strong> field is required';
			$required        = ! ! $registration_field['registration_custom_field_required'];
			$slug            = _wp_to_kebab_case( $name );
			if ( $required && empty( $post[ $slug ] ) ) {
				$errors->add( 'orion_required_field', __( sprintf( $validation_text, strtolower($name) ), 'orion' ) );
			}
		}

		return $errors;
	}
}