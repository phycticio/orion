<?php

add_filter('acf/load_field/name=api_key', function($field){
    $field['readonly'] = true;
    return $field;
});

add_filter('acf/load_field/name=environment', function($field){
    $field['readonly'] = true;
    return $field;
});

add_filter('acf/load_field/name=token', function($field){
    $field['readonly'] = true;
    return $field;
});
