<?php

namespace orion\actions\admin;

class Orion_Enqueue_Scripts {
	public static function start(): void {
		add_action( 'admin_enqueue_scripts', Orion_Enqueue_Scripts::wp_enqueue_scripts( ... ) );
	}

	public static function wp_enqueue_scripts(): void {
		wp_register_script(
			'orion',
			ORION_URL . 'dist/orion.js',
			[],
			ORION_VER,
			true
		);

		wp_register_style(
			'orion',
			ORION_URL . 'dist/orion.css',
			[],
			ORION_VER
		);
		wp_enqueue_style( 'orion' );
		wp_enqueue_script( 'orion' );
	}
}