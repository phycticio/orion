<?php

namespace orion\helpers;

class Custom_Post_Type {
	public static function labels( $plural, $singular ): array {
		return array(
			'name'                  => _x( $plural, 'Post type general name', 'orion' ),
			'singular_name'         => _x( $singular, 'Post type singular name', 'orion' ),
			'menu_name'             => _x( $plural, 'Admin Menu text', 'orion' ),
			'name_admin_bar'        => _x( $singular, 'Add New on Toolbar', 'orion' ),
			'add_new'               => __( 'Add New', 'orion' ),
			'add_new_item'          => __( 'Add New ' . $singular, 'orion' ),
			'new_item'              => __( 'New ' . $singular, 'orion' ),
			'edit_item'             => __( 'Edit ' . $singular, 'orion' ),
			'view_item'             => __( 'View ' . $singular, 'orion' ),
			'all_items'             => __( $plural, 'orion' ),
			'search_items'          => __( 'Search ' . $plural, 'orion' ),
			'parent_item_colon'     => __( 'Parent ' . $plural . ': ', 'orion' ),
			'not_found'             => __( 'No ' . $plural . ' found.', 'orion' ),
			'not_found_in_trash'    => __( 'No ' . $plural . ' found in Trash.', 'orion' ),
			'featured_image'        => _x( $singular . ' Featured Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'orion' ),
			'set_featured_image'    => _x( 'Set featured image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'orion' ),
			'remove_featured_image' => _x( 'Remove featured image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'orion' ),
			'use_featured_image'    => _x( 'Use as featured image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'orion' ),
			'archives'              => _x( $plural . ' archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'orion' ),
			'insert_into_item'      => _x( 'Insert into ' . $singular, 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'orion' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this ' . $singular, 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'orion' ),
			'filter_items_list'     => _x( 'Filter ' . $plural . ' list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'orion' ),
			'items_list_navigation' => _x( $plural . ' list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'orion' ),
			'items_list'            => _x( $plural . ' list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'orion' ),
		);
	}

	public static function args( $post_attributes ): array {
		$default_attributes = array(
			'public'             => false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'show_in_rest'       => true,
			'can_export'         => true,
			'menu_icon'          => 'dashicons-edit-page',
			'show_in_graphql'    => true,
		);

		return array_merge( $default_attributes, $post_attributes );
	}
}