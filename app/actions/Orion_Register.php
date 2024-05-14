<?php

namespace orion\actions;

use orion\helpers\Common;
use orion\helpers\View;
use WP_User;

class Orion_Register {
	public static function start(): void {
		add_action( 'register_form', self::register_form( ... ) );
		add_action( 'wp_new_user_notification_email', self::wp_new_user_notification_email( ... ), 10, 3 );
		add_action( 'register_new_user', self::register_new_user( ... ) );
	}

	public static function register_form(): void {
		$registration_fields = get_field( 'registration_custom_fields', ORION_SETTINGS_OBJECT_ID );
		$http_post           = ( 'POST' === $_SERVER['REQUEST_METHOD'] );
		if ( $http_post && ! empty( $_POST['orion_registration_fields'] ) ) {
			$post = array_map( function ( $item ) {
				return sanitize_text_field( $item );
			}, $_POST['orion_registration_fields'] );
		}
		if ( $registration_fields ) {
			$fields_string = '';
			foreach ( $registration_fields as $registration_field ) {
				$type       = $registration_field['registration_custom_field_type'];
				$name       = $registration_field['registration_custom_field_name'];
				$size       = $registration_field['registration_custom_field_size'];
				$required   = ! ! $registration_field['registration_custom_field_required'];
				$value      = $registration_field['registration_custom_field_value'];
				$label      = View::load_template( 'common/tag', [
						'tag'     => 'label',
						'content' => $name,
					] ) . ' ' . ( $required ? View::load_template( 'common/tag', [
						'tag'     => 'span',
						'content' => '*',
						'attrs'   => Common::parse_attrs( [
							'class' => 'registration-custom-field-required-mark'
						] ),
					] ) : '' );
				$field      = '';
				$slug       = _wp_to_kebab_case( $name );
				$field_name = "orion_registration_fields[{$slug}]";
				$field_id   = $type . '-' . _wp_to_kebab_case( $name );
				switch ( $type ) {
					case 'select':
						$field = $label . View::load_template( 'common/select', [
								'attrs'    => Common::parse_attrs( [
									'name'     => $field_name,
									'class'    => 'registration-custom-field-' . str_replace( '%', '', $size ),
									'required' => $required,
									'id'       => $field_id,
								] ),
								'options'  => $registration_field['registration_custom_field_select_options'],
								'selected' => $http_post && isset( $post ) ? $post[ $slug ] : '',
							] );
						break;
					case 'text':
					case 'email':
						$field = $label . View::load_template( 'wp-admin/input/text', [
								'attrs' => Common::parse_attrs( [
									'type'     => $type,
									'name'     => $field_name,
									'required' => $required,
									'id'       => $field_id,
									'value'    => $http_post && isset( $post ) ? $post[ $slug ] : '',
								] ),
							] );
						break;
					case 'checkbox':
					case 'radio':
						$field = View::load_template( 'wp-admin/input/checkbox', [
							'attrs' => Common::parse_attrs( [
								'type'     => $type,
								'name'     => $field_name,
								'id'       => $field_id,
								'required' => $required,
								'value'    => $value ?? 1,
							] ),
							'id'    => $field_id,
							'label' => $name . ' ' . ( $required ? View::load_template( 'common/tag', [
								'tag'     => 'span',
								'content' => '*',
								'attrs'   => Common::parse_attrs( [
									'class' => 'registration-custom-field-required-mark'
								] ),
							] ) : '' ),
						] );
				}
				$fields_string .= View::load_template( 'common/tag', [
					'tag'     => 'p',
					'content' => $field,
					'attrs'   => Common::parse_attrs( [
						'class' => 'registration-custom-field-' . str_replace( '%', '', $size ),
					] )
				] );
			}
			ob_start();
			echo View::load_template( 'common/tag', [
				'tag'     => 'div',
				'content' => $fields_string,
				'attrs'   => Common::parse_attrs( [
					'class' => 'registration_field_container',
				] )
			] );
			ob_end_flush();
		}
	}

	public static function wp_new_user_notification_email(
		array $wp_new_user_notification_email,
		WP_User $user,
		string $blog_name
	): array {
		$key = get_password_reset_key( $user );
		if ( is_wp_error( $key ) ) {
			return $wp_new_user_notification_email;
		}

		$login_url = empty( get_field( 'reset_password_url', 'option' ) ) ? 'wp-login.php' : get_field( 'reset_password_url', 'option' );
		$message   = sprintf( __( 'Username: %s' ), $user->user_login ) . "\r\n\r\n";
		$message   .= __( 'To set your password, visit the following address:' ) . "\r\n\r\n";
		$message   .= network_site_url( "$login_url/?action=rp&key=$key&login=" . rawurlencode( $user->user_login ), 'login' ) . "\r\n\r\n";

		$message .= wp_login_url() . "\r\n";

		$wp_new_user_notification_email['message'] = $message;

		return $wp_new_user_notification_email;
	}

	public static function register_new_user( int $user_id ): void {
		$post = array_map( function ( $item ) {
			return sanitize_text_field( $item );
		}, $_POST['orion_registration_fields'] );
		foreach ( $post as $key => $val ) {
			update_field( $key, $val, "user_{$user_id}" );
		}
	}
}