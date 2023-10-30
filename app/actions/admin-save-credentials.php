<?php

add_action('acf/options_page/save', function($post_id, $menu_slug) {
    if($menu_slug !== 'credentials') return;
    if(!get_field('generate_api_keys', 'option')) return;

    try {
        $api_key = bin2hex(random_bytes(32));
        $token = bin2hex(random_bytes(16));
    } catch (Exception $e) {
        $api_key = substr(md5(rand(0, 99999)), 0, 32);
        $token = substr(md5(get_bloginfo() . site_url() . time()), 0, 16);
    }


    update_field('api_key', $api_key, 'option');
    update_field('token', $token, 'option');
    update_field('generate_api_keys', false, 'option');
    update_field('are_you_sure', false, 'option');
}, 10, 2);
