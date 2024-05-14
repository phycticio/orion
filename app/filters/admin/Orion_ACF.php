<?php

namespace orion\filters\admin;

class Orion_ACF
{
    public static function start() : void {
        add_filter( 'acf/json/save_file_name', Orion_ACF::acf_json_filename(...), 10, 3 );
        add_filter( 'acf/settings/save_json', Orion_ACF::acf_json_save_point(...), 10, 3 );
        add_filter( 'acf/fields/google_map/api', Orion_ACF::acf_google_maps_api(...), 10, 3 );
    }

	public static function acf_google_maps_api($args) {
		$args['key'] = ORION_GOOGLE_MAPS_API_KEY;
		return $args;
	}

    /**
     * @param $path
     * @return string
     */
    public static function acf_json_save_point( $path ): string
    {
        return ORION_PATH . '/acf';
    }

    /**
     * @param $filename
     * @param $post
     * @param $load_path
     * @return string
     */
    public static function acf_json_filename( $filename, $post, $load_path ): string
    {
        return _wp_to_kebab_case( $post['title'] ) . '.json';
    }
}