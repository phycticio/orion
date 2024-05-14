<?php

namespace orion\actions\elementor;

class Orion_Elementor
{
    public static function start(): void
    {
        add_action( 'elementor_pro/forms/actions/register', Orion_Elementor::form_actions(...) );
    }

    public static function form_actions($form_actions_registrar): void
    {
        foreach(glob(__DIR__ . '/form_actions/*.php') as $form_action) {
            if(is_file($form_action)){
                $path_parts = pathinfo($form_action);
                $class_name = "orion\\actions\\elementor\\form_actions\\{$path_parts['filename']}";
                $form_actions_registrar->register( new $class_name() );
            }
        }
    }
}