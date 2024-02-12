<?php

namespace orion\actions\admin\post_types;

use orion\helpers\Custom_Post_Type;

class Orion_Fields {
	const POST_TYPE = 'orion_field';
	const POST_TYPE_SINGULAR = 'Field';
	const POST_TYPE_PLURAL = 'Fields';
	const POST_TYPE_SHOW_IN_MENU = 'crb_carbon_fields_container_general_settings.php';
	const POST_TYPE_MENU_POSITION = 80;
	const POST_TYPE_SUPPORT = [ 'title', 'author', 'revisions', 'custom_fields' ];

	public static function init(): void {
		add_action( 'init', self::register_post_type( ... ) );
	}

	public static function register_post_type(): void {
		$labels = Custom_Post_Type::labels( self::POST_TYPE_PLURAL, self::POST_TYPE_SINGULAR );
		$args   = Custom_Post_Type::args( [
			'post_type'           => self::POST_TYPE,
			'labels'              => $labels,
			'show_in_menu'        => self::POST_TYPE_SHOW_IN_MENU,
			'menu_position'       => self::POST_TYPE_MENU_POSITION,
			'supports'            => self::POST_TYPE_SUPPORT,
			'graphql_single_name' => 'custom_orion_field',
			'graphql_plural_name' => 'custom_orion_fields',
		] );
		register_post_type( self::POST_TYPE, $args );
	}
}