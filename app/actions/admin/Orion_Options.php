<?php

namespace orion\actions\admin;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use orion\helpers\Country;
use orion\helpers\View;

class Orion_Options {
	/**
	 * @return void
	 */
	public static function init(): void {
		add_action( 'carbon_fields_register_fields', self::carbon_fields_register_fields( ... ) );
	}

	public static function carbon_fields_register_fields(): void {
		$country        = new Country();
		$orion_options = Container::make( 'theme_options', __( 'General Settings', 'orion' ) )
		         ->set_page_menu_title( __('Orion', 'orion') )
		         ->set_icon( 'dashicons-admin-tools' );

		Container::make('theme_options', __('General Settings'))
		         ->set_page_parent($orion_options)
			->add_tab( __( 'Stack', 'orion' ), [
				Field::make( 'text', 'orion_stack_name', __( 'Stack Name', 'orion' ) ),
				Field::make( 'textarea', 'orion_stack_description', __( 'Description', 'orion' ) ),
				Field::make( 'association', 'orion_stack_owner', __( 'Owner', 'orion' ) )
				     ->set_types( [
					     [
						     'type' => 'user',
					     ],
				     ] ),
				Field::make( 'separator', 'orion_separator', __( 'Credentials' ) ),
				Field::make( 'text', 'orion_stack_api_key', __( 'Api Key', 'orion' ) ),
			] )
			->add_tab( __( 'Environments', 'orion' ), [
				Field::make( 'complex', 'environments', __( 'Environments', 'orion' ) )
				     ->set_min( 1 )
				     ->set_max( 3 )
				     ->add_fields( [
					     Field::make( 'text', 'orion_environment_name', __( 'Name', 'orion' ) ),
					     Field::make( 'text', 'orion_environment_base_url', __( 'Base URL', 'orion' ) ),
					     Field::make( 'color', 'orion_environment_color', __( 'Color', 'orion' ) )
					          ->set_palette( array( '#134f5c', '#a032a7', '#f1c232', '#d45d72', '#559f4c' ) ),
				     ] )
			] )
			->add_tab( __( 'Languages', 'orion' ), [
				Field::make( 'complex', 'languages', __( 'Languages', 'orion' ) )
				     ->set_min( 1 )
				     ->set_max( 3 )
				     ->add_fields( [
					     Field::make( 'select', 'orion_language', __( 'Name', 'orion' ) )
					          ->add_options( $country->get_languages() ),
					     Field::make( 'select', 'orion_fallback_language', __( 'Fallback Language', 'orion' ) )
					          ->add_options( $country->get_languages() ),
				     ] )
			] );
	}
}
