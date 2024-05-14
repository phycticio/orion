<?php

namespace orion\filters;

class Orion_General {
	public static function start() : void {
		add_filter('use_block_editor_for_post', '__return_false');
	}
}