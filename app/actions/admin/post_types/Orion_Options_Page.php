<?php

namespace orion\actions\admin\post_types;

use orion\helpers\Custom_Post_Type;

class Orion_Options_Page {
	const POST_TYPE = 'orion_options_page';
	const POST_TYPE_SINGULAR = 'Options Page';
	const POST_TYPE_PLURAL = 'Options Pages';
	const POST_TYPE_SHOW_IN_MENU = 'crb_carbon_fields_container_general_settings.php';
	const POST_TYPE_MENU_POSITION = 85;
	const POST_TYPE_SUPPORT = [ 'title', 'author', 'revisions' ];
	const POST_TYPE_ICON = 'dashicons-screenoptions';

	public static function init(): void {
		add_action( 'init', self::register_post_type( ... ) );
		add_action( 'save_post_' . self::POST_TYPE, ['orion\actions\admin\post_types\Orion_Options_Page', 'save_post'] );
	}

	public static function register_post_type(): void {
		$labels = Custom_Post_Type::labels( self::POST_TYPE_PLURAL, self::POST_TYPE_SINGULAR );
		$args   = Custom_Post_Type::args( [
			'post_type'     => self::POST_TYPE,
			'labels'        => $labels,
			'show_in_menu'  => self::POST_TYPE_SHOW_IN_MENU,
			'menu_position' => self::POST_TYPE_MENU_POSITION,
			'supports'      => self::POST_TYPE_SUPPORT,
			'icon'          => self::POST_TYPE_ICON,
		] );
		register_post_type( self::POST_TYPE, $args );
	}

	public static function save_post( $post_id ) : void {
		remove_action( 'save_post_' . self::POST_TYPE, ['orion\actions\admin\post_types\Orion_Options_Page', 'save_post'] );
		wp_update_post( [
			'ID'         => $post_id,
			'post_title' => carbon_get_post_meta( $post_id, 'orion_cpt_singular' ),
		] );
		add_action( 'save_post_' . self::POST_TYPE, ['orion\actions\admin\post_types\Orion_Options_Page', 'save_post'] );
	}
}