<?php

namespace orion\helpers;

class Common {
	public static function debug( $variable ) {
		wp_die( '<pre>' . print_r( $variable, 1 ) . '</pre>' );
	}

	public static function get_logo_url(): ?string {
		if ( get_field( 'use_custom_logo', 'option' ) ) {
			if ( ! ! get_field( 'logo_from_theme_settings', 'option' ) ) {
				$custom_logo_id  = get_theme_mod( 'custom_logo' );
				$logo            = wp_get_attachment_image_src( $custom_logo_id, 'full' );
				$logo_url        = $logo[0] ?? false;
				$has_custom_logo = $logo_url && has_custom_logo();
			} else {
				$logo_url        = get_field( 'custom_logo', 'option' );
				$has_custom_logo = ! ! $logo_url;
			}

			if ( $has_custom_logo ) {
				return esc_url( $logo_url );
			}

			return null;
		}

		return null;
	}

	public static function parse_attrs( array $attributes ): string {
		return join( ' ', array_map( function ( $key ) use ( $attributes ) {
			if ( $key === 'style' && is_array( $attributes[ $key ] ) ) {
				return self::parse_style_attrs( $attributes[ $key ] );
			}

			if ( is_bool( $attributes[ $key ] ) ) {
				return $attributes[ $key ] ? $key : '';
			}

			return "{$key}=\"{$attributes[$key]}\"";
		}, array_keys( $attributes ) ) );
	}

	public static function parse_style_attrs( array $styles ): string {
		return 'style="' . join( ';', array_map( function ( $key ) use ( $styles ) {
				return "{$key}:{$styles[$key]}";
			}, array_keys( $styles ) ) ) . '"';
	}
}