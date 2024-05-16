<?php

namespace orion\actions\admin;

use orion\helpers\Common;

class Orion_Save_Theme_Options {
	const POST_ID = 'option';
	const PAGE_NAME = 'orion-login-settings';

	public static function start(): void {
		add_action( 'acf/options_page/save', self::acf_options_page_save( ... ) );
	}

	public static function acf_options_page_save( string|int $post_id, string|null $menu_slug = null ): void {
		if (
			$post_id === 'options' &&
			(
				sanitize_text_field( $_GET['page'] ) === self::PAGE_NAME ||
				$menu_slug === self::PAGE_NAME
			)
		) {
			self::_save_pages();
			$styles = self::_save_styles();
			$styles = self::_save_font_family( $styles );
			$styles = self::_save_message_position( $styles );
			$styles = self::_save_notices_colors( $styles );
			$styles = self::_save_form_styles( $styles );
			$styles = self::_save_layout( $styles );
			self::_save_vars_file( $styles );
		}
	}

	private static function _save_styles(): array {
		if ( ! get_field( 'customize_login_page', self::POST_ID ) ) {
			return [];
		}
		$styles = [];
		$colors = [
			'background_color',
			'text_color',
			'link_color',
			'submit_button_bg_color',
			'submit_button_text_color',
			'container_background_color',
			'default_button_background_color',
			'default_button_text_color',
		];
		foreach ( $colors as $color ) {
			$styles["--orion-wp-login--{$color}"] = get_field( $color, self::POST_ID );
		}

		$custom_logo = Common::get_logo_url();
		if ( $custom_logo ) {
			$styles['--orion-wp-login--custom_logo'] = "url(\"{$custom_logo}\")";
		}

		$body_background_image = get_field( 'body_background_image', self::POST_ID );
		if ( ! empty( $body_background_image['url'] ) ) {
			$styles['--orion-wp-login--background_image'] = "url(\"{$body_background_image['url']}\")";
		}

		if ( get_field( 'use_custom_logo', self::POST_ID ) ) {
			$styles["--orion-wp-login--custom_logo_width"] = get_field( 'logo_width', self::POST_ID ) .
			                                                 get_field( 'logo_width_unit', self::POST_ID );

			$styles["--orion-wp-login--custom_logo_height"] = get_field( 'logo_height', self::POST_ID ) .
			                                                  get_field( 'logo_height_unit', self::POST_ID );
		}

		$styles["--orion-wp-login--login_container_width"] = get_field( 'container_width', 'option' ) .
		                                                     get_field( 'container_width_unit', 'option' );
		                                                     get_field( 'container_width_unit', 'option' );
		$logo_height                                       = get_field( 'container_height', 'option' );
		if ( $logo_height === 'auto' ) {
			$styles["--orion-wp-login--login_container_height"] = $logo_height;
		} else {
			$styles["--orion-wp-login--login_container_height"] = $logo_height .
			                                                      get_field( 'logo_height_unit', 'option' );
		}

		$styles['--orion-wp-login--backtoblock_display'] = get_field( 'show_back_to_blog', 'option' ) === 1 ?
			'block' : 'none';
		$styles['--orion-wp-login--show_privacy_policy_page_link'] = get_field( 'show_privacy_policy_page_link', 'option' ) === 1 ?
			'block' : 'none';

		return $styles;
	}

	private static function _save_pages(): void {
		self::_delete_session_pages();
		if ( ! get_field( 'custom_login_url', self::POST_ID ) ) {
			return;
		}

		self::_create_session_pages();
	}

	private static function _delete_session_pages(): void {
		global $wpdb;
		$posts = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT post_id, meta_key FROM {$wpdb->postmeta} WHERE meta_key = %s",
				ORION_META_KEY_PAGES_NAME
			)
		);

		if ( count( $posts ) === 0 ) {
			return;
		}

		foreach ( $posts as $meta ) {
			$metadata = get_post_meta( $meta->post_id );
			if ( count( $metadata ) > 0 ) {
				foreach ( $metadata as $key => $metadatum ) {
					delete_post_meta( $meta->post_id, $key );
				}
			}
			wp_delete_post( $meta->post_id, true );
		}
	}

	private static function _create_session_pages(): void {
		$custom_paths = [
			'login_url'          => get_field( 'login_url', self::POST_ID ),
			'register_url'       => get_field( 'register_url', self::POST_ID ),
			'lost_password_url'  => get_field( 'lost_password_url', self::POST_ID ),
			'reset_password_url' => get_field( 'reset_password_url', self::POST_ID ),
		];

		foreach ( $custom_paths as $custom_path ) {
			$post_id = wp_insert_post( [
				'post_title'  => ucwords( strtolower( $custom_path ) ),
				'post_name'   => _wp_to_kebab_case( $custom_path ),
				'post_type'   => 'page',
				'post_status' => 'publish',
			] );
			update_post_meta( $post_id, ORION_META_KEY_PAGES_NAME, 1 );
		}
	}

	private static function _save_font_family( array $styles = [] ): array {
		$font_family_data          = json_decode( get_option( 'font_family_data' ) );
		$current_font_family       = get_field( 'font-family', 'option' );
		$default_font_families     = [
			'serif'      => 'Serif',
			'sans-serif' => 'Sans serif',
			'monospace'  => 'Monospace',
			'cursive'    => 'Cursive',
			'fantasy'    => 'Fantasy',
			'system-ui'  => 'System UI',
		];
		$font_data_file            = ORION_PATH . 'generated/data/google-fonts.json';
		$google_font_hasnt_changed = ( ! empty( $font_family_data->family ) &&
		                               $current_font_family === _wp_to_kebab_case( $font_family_data->family ) );
		if ( $google_font_hasnt_changed ||
		     in_array( $current_font_family, array_keys( $default_font_families ) ) ||
		     $current_font_family === 'default' ||
		     ! is_file( $font_data_file ) ) {
			return self::_generate_font_style( $styles, $current_font_family, $default_font_families, $font_family_data );
		}

		$google_fonts_json    = json_decode( file_get_contents( $font_data_file ) );
		$selected_font_family = array_filter( $google_fonts_json->items, function ( $item ) use ( $current_font_family ) {
			return $current_font_family === _wp_to_kebab_case( $item->family );
		} );

		$selected_font_family = array_values( $selected_font_family )[0];
		update_option( 'font_family_data', json_encode( $selected_font_family ) );

		return self::_generate_font_style( $styles, $current_font_family, $default_font_families, $selected_font_family );
	}

	private static function _generate_font_style(
		array $styles,
		string $current_font_family,
		array $default_font_families,
		?object $font_family_data = null
	): array {
		if ( $current_font_family === 'default' ||
		     in_array( $current_font_family, array_keys( $default_font_families ) ) ) {
			$styles['--orion-wp-login--custom_font_family'] = $current_font_family;

			return $styles;
		} else {
			$google_fonts_url                               = 'https://fonts.googleapis.com/css2?';
			$google_fonts_url                               .= http_build_query( [
				'family' => $font_family_data->family,
			] );
			$styles['import']                               = "$google_fonts_url";
			$styles['--orion-wp-login--custom_font_family'] = "\"{$font_family_data->family}\", {$font_family_data->category}";
		}

		return $styles;
	}

	private static function _save_message_position( array $styles ): array {
		$message_position                             = get_field( 'message_position', 'option' );
		$styles['--orion-wp-login--message_position'] = $message_position === 'default' ? 'static' : 'absolute';
		if ( $message_position !== 'default' ) {
			$styles['--orion-wp-login--message_max_width'] = get_field( 'container_width', 'option' ) .
			                                                 get_field( 'container_width_unit', 'option' );
		}
		switch ( $message_position ) {
			case 'top-right':
				$styles['--orion-wp-login--message_top']   = '1rem';
				$styles['--orion-wp-login--message_right'] = '1rem';
				break;
			case 'top-center':
				$styles['--orion-wp-login--message_top'] = '1rem';
				break;
			case 'top-left':
				$styles['--orion-wp-login--message_top']  = '1rem';
				$styles['--orion-wp-login--message_left'] = '1rem';
				break;
			case 'bottom-right':
				$styles['--orion-wp-login--message_bottom'] = '1rem';
				$styles['--orion-wp-login--message_right']  = '1rem';
				break;
			case 'bottom-center':
				$styles['--orion-wp-login--message_bottom'] = '1rem';
				break;
			case 'bottom-left':
				$styles['--orion-wp-login--message_bottom'] = '1rem';
				$styles['--orion-wp-login--message_left']   = '1rem';
				break;
		}

		return $styles;
	}

	private static function _save_notices_colors( array $styles ): array {
		$styles['--orion-wp-login--notice_success'] = get_field( 'notice_success', 'option' );
		$styles['--orion-wp-login--notice_error']   = get_field( 'notice_error', 'option' );
		$styles['--orion-wp-login--notice_warning'] = get_field( 'notice_warning', 'option' );
		$styles['--orion-wp-login--notice_info']    = get_field( 'notice_info', 'option' );

		return $styles;
	}

	private static function _save_form_styles( array $styles ): array {
		$styles['--orion-wp-login--border_color']             = get_field( 'border_color', 'option' );
		$styles['--orion-wp-login--border_width']             = get_field( 'border_width', 'option' ) .
		                                                        get_field( 'border_width_unit', 'option' );
		$styles['--orion-wp-login--form_background_color']    = get_field( 'form_background_color', 'option' );
		$styles['--orion-wp-login--form_field_border_color']  = get_field( 'form_field_border_color', 'option' );
		$styles['--orion-wp-login--form_padding']             = get_field( 'form_padding', 'option' ) .
		                                                        get_field( 'form_padding_unit', 'option' );
		$styles['--orion-wp-login--form_border_radius']       = get_field( 'form_border_radius', 'option' ) .
		                                                        get_field( 'form_border_radius_unit', 'option' );
		$styles['--orion-wp-login--form_field_border']        = get_field( 'form_field_border', 'option' ) .
		                                                        get_field( 'form_field_border_unit', 'option' );
		$styles['--orion-wp-login--form_field_border_radius'] = get_field( 'form_field_border_radius', 'option' ) .
		                                                        get_field( 'form_field_border_radius_unit', 'option' );
		$styles['--orion-wp-login--form_width']               = get_field( 'form_width', 'option' ) .
		                                                        get_field( 'form_width_unit', 'option' );

		return $styles;
	}

	private static function _save_layout( array $styles ): array {
		$layout = get_field( 'login_layout', 'option' );
		if ( ! $layout ) {
			return $styles;
		}

		if ( $layout !== 'center' ) {
			$styles['--orion-wp-login--align_items']                     = 'stretch';
			$styles['--orion-wp-login--justify_content']                 = 'flex-start';
			$styles['--orion-wp-login--flex_direction']                  = 'row';
			$styles['--orion-wp-login--login_container_padding']         = '1rem';
			$styles['--orion-wp-login--login_container_margin']          = 0;
			$styles['--orion-wp-login--login_container_display']         = 'flex';
			$styles['--orion-wp-login--login_container_align_items']     = 'center';
			$styles['--orion-wp-login--login_container_direction']       = 'column';
			$styles['--orion-wp-login--login_container_justify_content'] = 'center';
		} else {
			$styles['--orion-wp-login--login_container_padding'] = '5% 0 0 0';
			$styles['--orion-wp-login--login_container_margin']  = 'auto';
		}

		if ( $layout === 'right' ) {
			$styles['--orion-wp-login--justify_content'] = 'flex-end';
		}

		return $styles;
	}

	private static function _save_vars_file( $styles ): void {
		if ( count( $styles ) > 0 ) {
			$file = ORION_PATH . 'generated/css/login-vars.css';
			if ( ! file_exists( $file ) ) {
				touch( $file );
			}
			$lines = '';
			if ( isset( $styles['import'] ) ) {
				if ( is_string( $styles['import'] ) ) {
					$import = wp_remote_get( $styles['import'] );
					if ( wp_remote_retrieve_response_code( $import ) === 200 ) {
						$lines .= wp_remote_retrieve_body( $import ) . "\n";
					}
				}
			}
			$lines .= "body.login {\n";
			foreach ( $styles as $key => $value ) {
				if ( $key === 'import' ) {
					continue;
				}
				if ( str_contains( $key, 'url' ) ) {
					$value = "\"{$value}\"";
				}
				$lines .= "\t{$key}: {$value};\n";
			}
			$lines .= "}\n";
			file_put_contents( $file, $lines );
		}
	}
}