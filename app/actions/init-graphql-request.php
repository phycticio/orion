<?php

add_action( 'init_graphql_request', function(){
    $api_key = strtoupper(get_field('api_key', 'option'));
    $token = get_field('token', 'option');

//    if(!is_user_logged_in()) {
//        if ($_SERVER["HTTP_{$api_key}"] !== $token) {
//            $error = new WP_Error(
//                'invalid-credentials',
//                __('Check your credentials to connect to your stack', 'orion')
//            );
//            wp_die($error, 403);
//        }
//    }
});
