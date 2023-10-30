<?php

add_filter( 'register_post_type_args', function( $args, $post_type ) {
    if($post_type !== 'company') return $args;
    $args['show_in_graphql'] = true;
    $args['graphql_single_name'] = acf_str_camel_case($post_type);
    $args['graphql_plural_name'] = acf_str_camel_case(str_plural($post_type));

    return $args;
}, 10, 2 );

/**
 * @param string $word
 * @return string
 */
function str_plural(string $word) : string {
    if(str_ends_with($word, 'y')) {
        $plural = substr($word, 0, strlen($word) - 1) . 'ies';
    } elseif(
        str_ends_with($word, 's') ||
        str_ends_with($word, 'z') ||
        str_ends_with($word, 'h')
    ) {
        $plural = "{$word}es";
    } else {
        $plural = "{$word}s";
    }
    return $plural;
}
