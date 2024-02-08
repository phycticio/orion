<?php

namespace orion\actions\admin\post_types;

use orion\helpers\Custom_Post_Type;

class Orion_CPT {
	const POST_TYPE = 'orion_cpt';
	const POST_TYPE_SINGULAR = 'Post Type';
	const POST_TYPE_PLURAL = 'Post Types';
	const POST_TYPE_SHOW_IN_MENU = 'crb_carbon_fields_container_general_settings.php';
	const POST_TYPE_MENU_POSITION = 80;
	const POST_TYPE_SUPPORT = [ 'author', 'revisions' ];

	public static function init(): void {
		add_action( 'init', self::register_post_type( ... ) );
		add_action( 'save_post_' . self::POST_TYPE, [ 'orion\actions\admin\post_types\Orion_CPT', 'save_post' ] );
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

	public static function save_post( $post_id ): void {
		remove_action( 'save_post_' . self::POST_TYPE, [ 'orion\actions\admin\post_types\Orion_CPT', 'save_post' ] );
		wp_update_post( [
			'ID'         => $post_id,
			'post_title' => carbon_get_post_meta( $post_id, 'orion_cpt_singular' ),
		] );
		add_action( 'save_post_' . self::POST_TYPE, [ 'orion\actions\admin\post_types\Orion_CPT', 'save_post' ] );
	}
}