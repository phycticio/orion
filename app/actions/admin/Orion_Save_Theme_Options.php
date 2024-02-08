<?php

namespace orion\actions\admin;

class Orion_Save_Theme_Options {
	public static function init() : void {
		add_action(
			'carbon_fields_theme_options_container_saved',
			self::carbon_fields_theme_options_container_saved(...)
		);
	}

	public static function carbon_fields_theme_options_container_saved($a) : void {

	}
}