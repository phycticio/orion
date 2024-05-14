<?php

namespace orion\option_pages;

class Orion_Settings_Main_Page {
	public static function start(): void {
		add_action( 'acf/init', self::acf_init( ... ) );
		add_action( 'acf/include_fields', self::acf_include_fields( ... ) );
	}

	public static function acf_init() {
		acf_add_options_page( array(
			'page_title' => 'Orion',
			'menu_slug'  => 'orion',
			'icon_url'   => 'dashicons-superhero',
			'menu_title' => esc_html__( 'Orion', 'orion' ),
			'position'   => 100,
			'redirect'   => false,
		) );
	}

	public static function acf_include_fields(): void {
		acf_add_local_field_group( array(
			'key'                   => 'group_663d30d230558',
			'title'                 => esc_html__( 'Notices colors', 'orion' ),
			'fields'                => array(
				array(
					'key'               => 'field_663d30d2ca241',
					'label'             => esc_html__( 'Success', 'orion' ),
					'name'              => 'notice_success',
					'aria-label'        => '',
					'type'              => 'color_picker',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '25',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '#00a32a',
					'enable_opacity'    => 0,
					'return_format'     => 'string',
				),
				array(
					'key'               => 'field_663d3217ca242',
					'label'             => esc_html__( 'Error', 'orion' ),
					'name'              => 'notice_error',
					'aria-label'        => '',
					'type'              => 'color_picker',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '25',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '#d63638',
					'enable_opacity'    => 0,
					'return_format'     => 'string',
				),
				array(
					'key'               => 'field_663d323cca243',
					'label'             => esc_html__( 'Warning', 'orion' ),
					'name'              => 'notice_warning',
					'aria-label'        => '',
					'type'              => 'color_picker',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '25',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '#dba617',
					'enable_opacity'    => 0,
					'return_format'     => 'string',
				),
				array(
					'key'               => 'field_663d328eca245',
					'label'             => esc_html__( 'Info', 'orion' ),
					'name'              => 'notice_info',
					'aria-label'        => '',
					'type'              => 'color_picker',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '25',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '#72aee6',
					'enable_opacity'    => 0,
					'return_format'     => 'string',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'orion',
					),
				),
			),
			'menu_order'            => 9,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => '',
			'show_in_rest'          => 0,
		) );
	}
}