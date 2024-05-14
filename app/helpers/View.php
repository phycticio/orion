<?php

namespace orion\helpers;

use Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class View {
	public static function load_template( string $template, array $data = [] ): string {
		require_once ORION_PATH . 'vendor/autoload.php';
		$loader   = new \Twig\Loader\FilesystemLoader( ORION_PATH . 'resources/views' );
		$twig     = new \Twig\Environment( $loader, [
			'cache'       => ORION_PATH . 'cache/',
			'auto_reload' => true,
			'debug'       => true,
		] );
		$template = str_replace( '.', '/', $template );
		try {
			$template = $twig->load( "{$template}.twig" );

			return $template->render( $data );
		} catch ( Exception|LoaderError|RuntimeError|SyntaxError $e ) {
			return '';
		}
	}
}

function View() {
	static $instance;
	if ( ! isset( $instance ) ) {
		$instance = new View();
	}

	return $instance;
}