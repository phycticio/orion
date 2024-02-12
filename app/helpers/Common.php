<?php

namespace orion\helpers;

class Common {
	public static function debug($variable) : void {
		wp_die('<pre>' . print_r($variable, 1) . '</pre>');
	}
}