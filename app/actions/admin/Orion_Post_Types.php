<?php

namespace orion\actions\admin;

use orion\actions\admin\post_types\Orion_CPT;
use orion\actions\admin\post_types\Orion_Field_Group;
use orion\actions\admin\post_types\Orion_Options_Page;
use orion\actions\admin\post_types\Orion_Registered_Custom_Fields;
use orion\actions\admin\post_types\Orion_Taxonomy;

class Orion_Post_Types {
	public static function init() : void {
		Orion_CPT::init();
		Orion_Taxonomy::init();
		Orion_Options_Page::init();
	}
}