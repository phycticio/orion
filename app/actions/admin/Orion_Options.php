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
		$country       = new Country();
		$orion_options = Container::make( 'theme_options', __( 'General Settings', 'orion' ) )
		                          ->set_page_menu_title( __( 'Orion', 'orion' ) )
		                          ->set_icon( 'dashicons-admin-tools' );

		Container::make( 'theme_options', __( 'General Settings' ) )
		         ->set_page_parent( $orion_options )
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
			         Field::make( 'complex', 'orion_environments', __( 'Environments', 'orion' ) )
			              ->set_min( 1 )
			              ->set_max( 3 )
			              ->setup_labels( [
				              'singular_name' => __( 'Environment', 'orion' ),
				              'plural_name'   => __( 'Environments', 'orion' ),
			              ] )
			              ->add_fields( [
				              Field::make( 'color', 'orion_environment_color', __( 'Color', 'orion' ) )
				                   ->set_width( 50 ),
				              Field::make( 'text', 'orion_environment_name', __( 'Name', 'orion' ) )
				                   ->set_width( 50 ),
				              Field::make( 'text', 'orion_environment_base_url', __( 'Base URL', 'orion' ) )
				                   ->set_width( 50 ),
				              Field::make( 'text', 'orion_environment_token', __( 'Token', 'orion' ) )
				                   ->set_width( 50 ),
			              ] )
		         ] )
		         ->add_tab( __( 'Languages', 'orion' ), [
			         Field::make( 'complex', 'orion_languages', __( 'Languages', 'orion' ) )
			              ->set_min( 1 )
			              ->set_max( 3 )
			              ->setup_labels( [
				              'singular_name' => __( 'Language', 'orion' ),
				              'plural_name'   => __( 'Languages', 'orion' ),
			              ] )
			              ->add_fields( [
				              Field::make( 'select', 'orion_language', __( 'Name', 'orion' ) )
				                   ->add_options( $country->get_languages() )->set_width( 50 ),
				              Field::make( 'select', 'orion_fallback_language', __( 'Fallback Language', 'orion' ) )
				                   ->add_options( $country->get_languages() )->set_width( 50 ),
			              ] )
		         ] )
		         ->add_tab( __( 'Revisions & Heartbeat', 'orion' ), [
			         Field::make( 'text', 'orion_revisions_amount', __( 'Amount of revisions', 'orion' ) )
			              ->set_attribute( 'type', 'number' )->set_width( 50 ),
			         Field::make( 'select', 'orion_heartbeat_status', __( 'Heartbeat', 'orion' ) )
			              ->set_options( [
				              'on'  => __( 'On', 'orion' ),
				              'off' => __( 'Off', 'orion' ),
			              ] )->set_width( 50 ),
		         ] );
	}
}
