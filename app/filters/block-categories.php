<?php

$block_categories = [
    [
        'slug' => 'orion-blocks',
        'title' => __('Orion', 'orion'),
        'icon' => '',
    ]
];

add_filter('block_categories', function($categories, $post) use ($block_categories) {
    $category_slugs = wp_list_pluck($categories, 'slug');
    if (!in_array('orion-blocks', $category_slugs)) {
        array_splice($categories, 1, 0, $block_categories);
    }
    return $categories;
}, 10, 2);