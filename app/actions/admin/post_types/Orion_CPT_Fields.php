<?php

namespace orion\actions\admin\post_types;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use orion\helpers\View;
use function orion\helpers\View;

class Orion_CPT_Fields {
	const POST_TYPE = 'orion_cpt';

	public static function init(): void {
		add_action( 'carbon_fields_register_fields', self::carbon_fields_register_fields( ... ) );
	}

	public static function carbon_fields_register_fields() {
		$taxonomies = get_taxonomies( null, 'objects' );
		Container::make( 'post_meta', __( 'Post Type Properties' ) )
		         ->where( 'post_type', '=', self::POST_TYPE )
		         ->add_tab( __( 'General', 'orion' ), self::get_general_fields( $taxonomies ) )
		         ->add_tab( __( 'Supports', 'orion' ), self::get_supports_fields() )
		         ->add_tab( __( 'Menu', 'orion' ), self::get_menu_fields() )
		         ->add_tab( __( 'GraphQL', 'orion' ), self::get_graphql_fields() )
		         ->add_tab( __( 'Fields', 'orion' ), self::get_fields_fields() );
	}

	public static function get_general_fields( $taxonomies ): array {
		return [
			Field::make( 'text', 'orion_cpt_plural', __( 'Plural Label', 'orion' ) ),
			Field::make( 'text', 'orion_cpt_singular', __( 'Singular Label', 'orion' ) ),
			Field::make( 'text', 'orion_cpt_slug', __( 'Slug', 'orion' ) ),
			Field::make( 'text', 'orion_cpt_description', __( 'Description', 'orion' ) ),
			Field::make( 'multiselect', 'orion_cpt_taxonomies', __( 'Taxonomies', 'orion' ) )
			     ->set_options( array_map( function ( $taxonomy ) {
				     return $taxonomy->label;
			     }, $taxonomies ) ),
			Field::make( 'separator', 'orion_cpt_separator', '' ),
			Field::make( 'checkbox', 'orion_cpt_public', __( 'Public', 'orion' ) ),
			Field::make( 'checkbox', 'orion_cpt_hierarchical', __( 'Hierarchical', 'orion' ) ),
		];
	}

	public static function get_supports_fields(): array {
		return [
			Field::make( 'set', 'orion_cpt_support', __( 'Choose Options' ) )
			     ->set_options( [
				     'title'           => __( 'Title', 'orion' ),
				     'content'         => __( 'Editor (content)', 'orion' ),
				     'author'          => __( 'Author', 'orion' ),
				     'thumbnail'       => __( 'Featured Image', 'orion' ),
				     'excerpt'         => __( 'Excerpt', 'orion' ),
				     'trackbacks'      => __( 'Track backs', 'orion' ),
				     'comments'        => __( 'Comments', 'orion' ),
				     'revisions'       => __( 'Revisions', 'orion' ),
				     'page-attributes' => __( 'Page Attributes', 'orion' ),
			     ] ),
		];
	}

	public static function get_menu_fields(): array {
		return [
			Field::make( 'text', 'orion_cpt_menu_icon_url', __( 'Icon URL' ) ),
			Field::make( 'checkbox', 'orion_cpt_show_in_menu', __( 'Show in Menu', 'orion' ) ),
			Field::make( 'text', 'orion_cpt_menu_position', __( 'Menu position', 'orion' ) )
			     ->set_attribute( 'type', 'number' )
			     ->set_conditional_logic( [
				     [
					     'field' => 'orion_cpt_show_in_menu',
					     'value' => true
				     ]
			     ] ),
		];
	}

	public static function get_graphql_fields(): array {
		$graph_ql_name_message = __( implode(
			[
				'Camel case string with no punctuation or',
				'&nbsp;',
				'spaces. Needs to start with a letter (not a number).',
				'&nbsp;',
				'<a href="https://www.wpgraphql.com/docs/custom-post-types" target="_blank">',
				__( 'More info', 'orion' ),
				'<a>'
			]
		), 'orion' );

		return [
			Field::make( 'text', 'orion_cpt_graphql_single_name', __( 'Single Name', 'orion' ) )
			     ->set_help_text( $graph_ql_name_message ),
			Field::make( 'text', 'orion_cpt_graphql_plural_name', __( 'Plural Name', 'orion' ) ),
			Field::make( 'html', 'orion_cpt_graphql_plural_name_help' )
			     ->set_help_text( $graph_ql_name_message ),
			Field::make( 'select', 'orion_cpt_graphql_kind', __( 'Plural Name', 'orion' ) )
			     ->set_options( [
				     'object'    => __( 'Object', 'orion' ),
				     'interface' => __( 'Interface', 'orion' ),
				     'union'     => __( 'Union', 'orion' ),
			     ] ),
		];
	}

	public static function get_fields_fields(): array {
		return [
			Field::make( 'complex', 'orion_fields', __( 'Data', 'orion' ) )
			     ->set_min( 1 )
			     ->setup_labels( [
				     'singular_name' => __( 'Field', 'orion' ),
				     'plural_name'   => __( 'Fields', 'orion' ),
			     ] )
			     ->set_header_template( 'Group <%- $_index %>' )
			     ->set_collapsed( true )
			     ->set_layout( 'tabbed-vertical' )
			     ->set_default_value( array(
				     [
					     'orion_cf_type' => 'text',
				     ]
			     ) )
			     ->add_fields( [
				     Field::make( 'select', 'orion_cf_type', __( 'Type', 'orion' ) )
				          ->set_options( [
					          'text'   => __( 'Text', 'orion' ),
					          'select' => __( 'Select', 'orion' ),
				          ] ),
				     Field::make( 'text', 'orion_cf_field_slug', __( 'Field slug', 'orion' ) )
				          ->set_help_text( __( 'A lowercase string with dash or underscore.', 'orion' ) ),
				     Field::make( 'text', 'orion_cf_plural_label', __( 'Plural label', 'orion' ) ),
				     Field::make( 'text', 'orion_cf_singular_label', __( 'Singular label', 'orion' ) ),
			     ] )
		];
	}
}