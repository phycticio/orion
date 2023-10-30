<?php

add_action('admin_enqueue_scripts', function(){
    wp_register_script(
        'orion',
        ORION_URL . '/dist/orion.js',
        [],
        ORION_VER,
        true
    );

    wp_enqueue_script('orion');
});
