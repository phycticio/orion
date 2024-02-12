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
			Field::make( 'select', 'orion_cpt_graphql_kind', __( 'GraphQL Kind', 'orion' ) )
			     ->set_options( [
				     'object'    => __( 'Object', 'orion' ),
				     'interface' => __( 'Interface', 'orion' ),
				     'union'     => __( 'Union', 'orion' ),
			     ] ),
		];
	}

	public static function get_fields_fields(): array {
		return [
			Field::make( 'complex', 'orion_cpt_containers', __( 'Containers', 'orion' ) )
			     ->set_min( 1 )
			     ->setup_labels( [
				     'singular_name' => __( 'Container', 'orion' ),
				     'plural_name'   => __( 'Containers', 'orion' ),
			     ] )
			     ->set_collapsed( true )
			     ->set_header_template( 'Container <%- $_index %>' )
			     ->set_default_value( array(
				     [
					     'orion_cpt_container_name' => __( 'Container', 'orion' ),
				     ]
			     ) )
			     ->add_fields( 'orion_ctp_container', __( 'Container', 'orion' ), [
				     Field::make( 'text', 'orion_cpt_container_name', __( 'Name', 'orion' ) ),
				     Field::make( 'complex', 'orion_cpt_fields', __( 'Fields', 'orion' ) )
				          ->set_min( 1 )
				          ->setup_labels( [
					          'singular_name' => __( 'Field', 'orion' ),
					          'plural_name'   => __( 'Fields', 'orion' ),
				          ] )
				          ->set_header_template( 'Field <%- $_index %>' )
				          ->set_collapsed( true )
				          ->set_default_value( array(
					          [
						          'orion_cf_type' => 'text',
					          ]
				          ) )
				          ->add_fields( 'orion_ctp_container_fields', __( 'Field', 'orion' ), [
					          Field::make( 'checkbox', 'orion_ctp_cf_required', __( 'Required', 'orion' ) ),
					          Field::make( 'select', 'orion_cpt_cf_type', __( 'Type', 'orion' ) )
					               ->set_options( static::get_field_types() )
					               ->set_width( 50 ),
					          Field::make( 'text', 'orion_cpt_cf_field_slug', __( 'Field slug', 'orion' ) )
					               ->set_required()
					               ->set_help_text( __( 'A lowercase string with dash or underscore.', 'orion' ) )
					               ->set_classes( 'orion-cpt-field-slug' )
					               ->set_width( 50 ),
					          Field::make( 'text', 'orion_cpt_cf_singular_label', __( 'Label', 'orion' ) )
					               ->set_required()
					               ->set_width( 33.33 ),
					          Field::make( 'text', 'orion_cpt_cf_default_placeholder', __( 'Placeholder', 'orion' ) )
					               ->set_width( 33.33 ),
					          Field::make( 'text', 'orion_cpt_cf_default_value', __( 'Default value', 'orion' ) )
					               ->set_width( 33.33 ),
					          Field::make( 'textarea', 'orion_cpt_cf_description', __( 'Description text' ) )
					               ->set_width( 25 ),
					          Field::make( 'textarea', 'orion_cpt_cf_help_text', __( 'Help text' ) )
					               ->set_width( 25 ),
					          Field::make( 'select', 'orion_cpt_cf_width', __( 'Width', 'orion' ) )
					               ->set_options( [ 25 => 25, 33.33 => 33, 50 => 50, 100 => 100 ] )
					               ->set_default_value( '100' )
					               ->set_width( 25 )
					               ->set_help_text( __( 'Percentage of the container the field should take', 'orion' ) ),
					          Field::make( 'text', 'orion_cpt_cf_class_name', __( 'Class names', 'orion' ) )
					               ->set_width( 25 )
					               ->set_help_text( __( 'Space separated class names for the fields', 'orion' ) ),
					          Field::make( 'textarea', 'orion_ctp_cf_select_options', __( 'Options', 'orion' ) )
					               ->set_help_text( __( 'Enter each choice on a new line.<br>
For more control, you may specify both a value and label like this:<br>
red : Red', 'orion' ) )
					               ->set_conditional_logic( [
						               [
							               'field' => 'orion_cpt_cf_type',
							               'value' => 'select',
						               ]
					               ] ),
					          Field::make( 'text', 'orion_ctp_cf_checkbox_value', __( 'Option value', 'orion' ) )
					               ->set_conditional_logic( [
						               [
							               'field' => 'orion_cpt_cf_type',
							               'value' => 'checkbox',
						               ]
					               ] ),
					          Field::make( 'complex', 'orion_ctp_cf_color_palette', __( 'Palette', 'orion' ) )
					               ->set_layout( 'tabbed-horizontal' )
					               ->set_conditional_logic( [
						               [
							               'field' => 'orion_cpt_cf_type',
							               'value' => 'color',
						               ]
					               ] )
					               ->add_fields( 'orion_ctp_cf_color_palette_colors', __( 'Color', 'orion' ), [
						               Field::make( 'color', 'orion_ctp_cf_color_palette_color', __( 'Color', 'orion' ) )
					               ] ),
					          Field::make(
						          'checkbox',
						          'orion_ctp_cf_color_set_alpha_enabled',
						          __( 'Alpha enabled', 'orion' )
					          )
					               ->set_help_text( __( 'Allow color opacity/transparency', 'orion' ) )
					               ->set_conditional_logic( [
						               [
							               'field' => 'orion_cpt_cf_type',
							               'value' => 'color',
						               ]
					               ] ),
					          Field::make( 'text', 'orion_ctp_cf_date_input_format', __( 'Input format', 'orion' ) )
					               ->set_help_text( __(
							               sprintf(
								               implode( ' ', [
									               'Select the date format the users are going to see.',
									               implode( '', [
										               '<a style="text-decoration: none;" href="%s" target="_blank">' .
										               '<span class="dashicons dashicons-share-alt2"></span>',
										               'PHP Guide',
										               '</a>'
									               ] )
								               ] ),
								               'https://www.php.net/manual/en/function.date.php'
							               ),
							               'orion'
						               )
					               )
					               ->set_default_value( get_option( 'date_format' ) )
					               ->set_width( 50 )
					               ->set_conditional_logic( [
						               'relation' => 'OR',
						               [
							               'field' => 'orion_cpt_cf_type',
							               'value' => 'date',
						               ],
						               [
							               'field' => 'orion_cpt_cf_type',
							               'value' => 'date_time',
						               ]
					               ] ),
					          Field::make( 'text', 'orion_ctp_cf_date_store_format', __( 'Store format', 'orion' ) )
					               ->set_help_text(
						               sprintf(
							               implode( ' ', [
								               'Select the date format that APIs will see.',
								               implode( '', [
									               '<a style="text-decoration: none;" href="%s" target="_blank">' .
									               '<span class="dashicons dashicons-share-alt2"></span>',
									               'PHP Guide',
									               '</a>'
								               ] )
							               ] ),
							               'https://www.php.net/manual/en/function.date.php'
						               )
					               )
					               ->set_default_value( get_option( 'date_format' ) )
					               ->set_width( 50 )
					               ->set_conditional_logic( [
						               'relation' => 'OR',
						               [
							               'field' => 'orion_cpt_cf_type',
							               'value' => 'date',
						               ],
						               [
							               'field' => 'orion_cpt_cf_type',
							               'value' => 'date_time',
						               ]
					               ] ),
					          Field::make( 'multiselect', 'orion_cpt_cf_file_allowed_types', __( 'Allowed file types', 'orion' ) )
					               ->set_options( [
						               'audio' => __( 'Audio', 'orion' ),
						               'video' => __( 'Video', 'orion' ),
						               'image' => __( 'Image', 'orion' ),
						               'pdf'   => __( 'PDF', 'orion' ),
						               'doc'   => __( 'doc', 'orion' ),
						               'docx'  => __( 'docx', 'orion' ),
						               'xls'   => __( 'xls', 'orion' ),
						               'xlsx'  => __( 'xlsx', 'orion' ),
					               ] )
					               ->set_default_value( 'image' )
					               ->set_conditional_logic( [
						               [
							               'field' => 'orion_cpt_cf_type',
							               'value' => 'file',
						               ]
					               ] ),
					          Field::make( 'checkbox', 'orion_cpt_cf_file_value_type', __( 'Return URL of file', 'orion' ) )
					               ->set_option_value( 'yes' )
					               ->set_conditional_logic( [
						               [
							               'field' => 'orion_cpt_cf_type',
							               'value' => 'file',
						               ]
					               ] )
				          ] )
			     ] )
		];
	}


	private static function get_field_types(): array {
		return [
			'text'      => __( 'Text', 'orion' ),
			'rich_text' => __( 'Rich text', 'orion' ),
			'number'    => __( 'Number', 'orion' ),
			'select'    => __( 'Select', 'orion' ),
			'checkbox'  => __( 'Checkbox', 'orion' ),
			'color'     => __( 'Color', 'orion' ),
			'date'      => __( 'Date', 'orion' ),
			'date_time' => __( 'Date time', 'orion' ),
			'file'      => __( 'File', 'orion' )
		];
	}
}