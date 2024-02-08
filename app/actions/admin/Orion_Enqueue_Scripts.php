<?php

namespace orion\actions\admin;

class Orion_Enqueue_Scripts {
	public static function init(): void {
		add_action( 'wp_enqueue_scripts', Orion_Enqueue_Scripts::wp_register_scripts( ... ) );
		add_action( 'wp_enqueue_scripts', Orion_Enqueue_Scripts::wp_enqueue_scripts( ... ) );
	}

	public static function wp_register_scripts(): void {
		wp_register_script(
			'orion',
			ORION_URL . 'dist/orion.js',
			[],
			filemtime( ORION_PATH . '/dist/orion.js' ),
			true
		);

		wp_register_style(
			'orion',
			ORION_URL . 'dist/orion.css',
			[],
			filemtime( ORION_PATH . '/dist/orion.css' )
		);
	}

	public static function wp_enqueue_scripts(): void {
		wp_enqueue_style( 'orion' );
		wp_enqueue_script( 'orion' );
	}
}