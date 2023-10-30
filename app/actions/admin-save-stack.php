<?php

add_action('acf/options_page/save', function($post_id, $menu_slug) {
    if($menu_slug !== 'stack') return;
}, 10, 2);
