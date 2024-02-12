<?php

namespace orion\actions\admin\post_types;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use orion\helpers\Common;
use orion\helpers\Custom_Post_Type;

class Orion_CPT {
	const POST_TYPE = 'orion_cpt';
	const POST_TYPE_SINGULAR = 'Post Type';
	const POST_TYPE_PLURAL = 'Post Types';
	const POST_TYPE_SHOW_IN_MENU = 'crb_carbon_fields_container_general_settings.php';
	const POST_TYPE_MENU_POSITION = 80;
	const POST_TYPE_SUPPORT = [ 'title', 'author', 'revisions' ];

	public static function init(): void {
		add_action( 'init', self::register_post_type( ... ) );
		add_action( 'save_post_' . self::POST_TYPE, [ 'orion\actions\admin\post_types\Orion_CPT', 'save_post' ] );
		add_action( 'carbon_fields_register_fields', self::register_custom_post_fields( ... ) );
		add_action( 'graphql_register_types', [
			'orion\actions\admin\post_types\Orion_CPT',
			'graphql_register_types'
		] );
	}

	public static function register_post_type(): void {
		$labels = Custom_Post_Type::labels( self::POST_TYPE_PLURAL, self::POST_TYPE_SINGULAR );
		$args   = Custom_Post_Type::args( [
			'post_type'           => self::POST_TYPE,
			'labels'              => $labels,
			'show_in_menu'        => self::POST_TYPE_SHOW_IN_MENU,
			'menu_position'       => self::POST_TYPE_MENU_POSITION,
			'supports'            => self::POST_TYPE_SUPPORT,
			'graphql_single_name' => 'custom_post_type',
			'graphql_plural_name' => 'custom_post_types',
		] );
		register_post_type( self::POST_TYPE, $args );

		$registered_custom_post_types = get_posts( [
			'post_type'      => self::POST_TYPE,
			'posts_per_page' => - 1,
		] );

		if ( ! count( $registered_custom_post_types ) ) {
			return;
		}

		self::register_custom_post_types( $registered_custom_post_types );
	}

	public static function register_custom_post_types( $registered_custom_post_types ): void {
		foreach ( $registered_custom_post_types as $post_type ) {
			$post_id  = $post_type->ID;
			$slug     = carbon_get_post_meta( $post_id, 'orion_cpt_slug' );
			$plural   = carbon_get_post_meta( $post_id, 'orion_cpt_plural' );
			$singular = carbon_get_post_meta( $post_id, 'orion_cpt_singular' );
			$labels   = Custom_Post_Type::labels( $plural, $singular );
			$args     = Custom_Post_Type::args( [
				'post_type'           => carbon_get_post_meta( $post_id, 'orion_cpt_slug' ),
				'labels'              => $labels,
				'show_in_menu'        => carbon_get_post_meta( $post_id, 'orion_cpt_show_in_menu' ),
				'menu_position'       => carbon_get_post_meta( $post_id, 'orion_cpt_menu_position' ),
				'supports'            => carbon_get_post_meta( $post_id, 'orion_cpt_support' ),
				'menu_icon'           => carbon_get_post_meta( $post_id, 'orion_cpt_menu_icon_url' ),
				'graphql_single_name' => carbon_get_post_meta( $post_id, 'orion_cpt_graphql_single_name' ),
				'graphql_plural_name' => carbon_get_post_meta( $post_id, 'orion_cpt_graphql_plural_name' ),
				'graphql_kind'        => carbon_get_post_meta( $post_id, 'orion_cpt_graphql_kind' ),
			] );
			register_post_type( $slug, $args );
		}
	}

	public static function register_custom_post_fields(): void {
		$registered_custom_post_types = get_posts( [
			'post_type'      => self::POST_TYPE,
			'posts_per_page' => - 1,
		] );

		if ( ! count( $registered_custom_post_types ) ) {
			return;
		}

		foreach ( $registered_custom_post_types as $post_type ) {
			$post_type_id   = $post_type->ID;
			$post_type_slug = get_post_meta( $post_type_id, "_orion_cpt_slug", true );
			$containers     = get_post_meta( $post_type_id, 'orion_cpt_containers', true );

			if ( ! $containers ) {
				return;
			}

			foreach ( $containers as $container ) {
				$container_fields = $container['orion_cpt_fields'];
				$fields           = [];
				foreach ( $container_fields as $container_field ) {
					$switch_type   = trim( $container_field['orion_cpt_cf_type'] );
					$type          = $switch_type === 'number' ? 'text' : $switch_type;
					$name          = 'orion_cf_' . _wp_to_kebab_case( $container_field['orion_cpt_cf_field_slug'] );
					$label         = __( $container_field['orion_cpt_cf_singular_label'], 'orion' );
					$default_value = trim( $container_field['orion_cpt_cf_default_value'] ) ?? '';
					$field         = Field::make( $type, $name, $label )
					                      ->set_default_value( $default_value )
					                      ->set_required( $container_field['orion_ctp_cf_required'] ?? false )
					                      ->set_help_text( $container_field['orion_cpt_cf_help_text'] ?? '' )
					                      ->set_width( $container_field['orion_cpt_cf_width'] )
					                      ->set_classes( $container_field['orion_cpt_cf_class_name'] ?? '' )
					                      ->set_visible_in_rest_api();

					if (
						! in_array( 'orion_cpt_cf_default_placeholder', $container_field ) &&
						$container_field['orion_cpt_cf_default_placeholder'] != ''
					) {
						$field->set_attribute(
							'placeholder',
							$container_field['orion_cpt_cf_default_placeholder'] ?? ''
						);
					}

					switch ( $switch_type ) {
						case 'select':
							$field->set_options( static::get_options( $container_field ) );
							break;
						case 'number':
							$field->set_attribute( 'type', $switch_type );
							break;
						case 'checkbox':
							$field->set_option_value( $container_field['orion_ctp_cf_checkbox_value'] );
							break;
						case 'color':
							if ( ! empty( $container_field['orion_ctp_cf_color_palette'] ) ) {
								$field->set_palette( array_map( function ( $color ) {
									return $color['orion_ctp_cf_color_palette_color'];
								}, $container_field['orion_ctp_cf_color_palette'] ) );
							}
							if ( ! empty( $container_field['orion_ctp_cf_color_set_alpha_enabled'] ) ) {
								$field->set_alpha_enabled( $container_field['orion_ctp_cf_color_set_alpha_enabled'] );
							}
							break;
						case 'date':
							if ( ! empty( $container_field['orion_ctp_cf_date_store_format'] ) ) {
								$field->set_storage_format( $container_field['orion_ctp_cf_date_store_format'] );
							}

							if ( ! empty( $container_field['orion_ctp_cf_date_input_format'] ) ) {
								$field->set_input_format(
									$container_field['orion_ctp_cf_date_input_format'],
									$container_field['orion_ctp_cf_date_input_format']
								);
							}
							break;
						case 'file':
							if ( count( $container_field['orion_cpt_cf_file_allowed_types'] ) > 0 ) {
								$field->set_type( $container_field['orion_cpt_cf_file_allowed_types'] );
							}

							if ( ! empty( $container_field['orion_cpt_cf_file_value_type'] ) ) {
								$field->set_value_type( 'url' );
							}

							break;
					}

					try {
						add_filter(
							'register_post_type_args',
							function ( $args, $post_type ) use ( $label, $post_type_slug ) {
								if ( $post_type_slug === $post_type ) {
									$filtered_label = _wp_to_kebab_case( $label );
									$graphql_fields = [];
									if ( array_key_exists( 'graphql_fields', $args ) ) {
										$graphql_fields = $args['graphql_fields'];
									}
									$graphql_fields[]       = $filtered_label;
									$args['graphql_fields'] = $graphql_fields;
								}

								return $args;
							}, 10, 2 );
					} catch ( \Exception $e ) {
						wp_die( $e->getMessage() );
					}

					$fields[] = $field;
				}
				Container::make( 'post_meta', __( $container['orion_cpt_container_name'], 'orion' ) )
				         ->where( 'post_type', '=', trim( $post_type_slug ) )
				         ->add_fields( $fields );
			}
		}

		$environments  = carbon_get_theme_option( 'orion_environments' );
		$options       = array_map( function ( $option ) {
			return $option['orion_environment_name'];
		}, $environments );
		$common_fields = [
			Field::make( 'set', 'orion_publish_to', __( 'Environments', 'orion' ) )
			     ->set_options( $options )
		];
		Container::make( 'post_meta', __( 'Publish to', 'orion' ) )
		         ->set_context( 'side' )
		         ->set_priority( 'high' )
		         ->add_fields( $common_fields );
	}

	public static function graphql_register_types(): void {
		$registered_custom_post_types = get_posts( [
			'post_type'      => self::POST_TYPE,
			'posts_per_page' => - 1,
		] );

		if ( ! count( $registered_custom_post_types ) ) {
			return;
		}

		foreach ( $registered_custom_post_types as $post_type ) {
			$post_type_id   = $post_type->ID;
			$post_type_slug = get_post_meta( $post_type_id, "_orion_cpt_slug", true );
			$containers     = get_post_meta( $post_type_id, 'orion_cpt_containers', true );

			if ( ! $containers ) {
				return;
			}

			foreach ( $containers as $container ) {
				$container_fields = $container['orion_cpt_fields'];
				$container_name   = _wp_to_kebab_case( $container['orion_cpt_container_name'] );
				foreach ( $container_fields as $container_field ) {
					try {
						register_graphql_field(
							$post_type_slug,
							"{$container_name}.{$container_field['orion_cpt_cf_field_slug']}",
							[
								'description' => $container_field['orion_cpt_cf_description'] ??
								                 "Field {$container_field['orion_cpt_cf_singular_label']}",
								'type'        => 'string',
								'resolve'     => function ( $post, $args, $context, $info ) use ( $container_field ) {
									$value = carbon_get_post_meta(
										$post->databaseId,
										'orion_cf_' . $container_field['orion_cpt_cf_field_slug']
									);

									return $value;
								}
							]
						);
					} catch ( \Exception $e ) {
					}
				}
			}
		}
	}

	public static function map_field_to_graphql_type( string $container_field_type ): string {

	}

	public static function get_options( array $field ): array {
		$orion_cf_options = explode( "\n", $field['orion_ctp_cf_select_options'] );
		$options          = [];
		foreach ( $orion_cf_options as $option ) {
			if ( ! str_contains( $option, ':' ) ) {
				$options[] = trim( $option );
				continue;
			}
			$exploded                        = explode( ':', $option );
			$options[ trim( $exploded[0] ) ] = trim( $exploded[1] );
		}

		return $options;
	}

	public static function get_fields( int $post_type_id ): array {
		return get_post_meta( $post_type_id, 'orion_cpt_fields' );
	}

	public static function save_post( $post_id ): void {
		remove_action( 'save_post_' . self::POST_TYPE, [ 'orion\actions\admin\post_types\Orion_CPT', 'save_post' ] );
		wp_update_post( [
			'ID'         => $post_id,
			'post_title' => carbon_get_post_meta( $post_id, 'orion_cpt_singular' ),
		] );
		$containers = carbon_get_post_meta( $post_id, 'orion_cpt_containers' );
		update_post_meta( $post_id, 'orion_cpt_containers', $containers );
		add_action( 'save_post_' . self::POST_TYPE, [ 'orion\actions\admin\post_types\Orion_CPT', 'save_post' ] );
	}
}