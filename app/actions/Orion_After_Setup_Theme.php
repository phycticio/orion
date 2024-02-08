<?php

namespace orion\actions;

class Orion_After_Setup_Theme {
	public static function init() : void {
		add_action('after_setup_theme', self::after_setup_theme(...));
	}

	public static function after_setup_theme(){
		\Carbon_Fields\Carbon_Fields::boot();
	}
}