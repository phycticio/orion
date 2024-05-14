<?php

namespace orion\actions\elementor\form_actions;

use Elementor\Controls_Manager;
use orion\helpers\Common;

class Orion_Login extends \ElementorPro\Modules\Forms\Classes\Action_Base {

    public function get_name(): string
    {
        return 'orion-login';
    }

    public function get_label(): string
    {
        return esc_html__('Login', 'orion');
    }

    public function run($record, $ajax_handler): void
    {
        $settings = $record->get( 'form_settings' );
        $raw_fields = $record->get( 'fields' );
        $redirect_to = $settings['orion_login_redirect_to'];

        $post_fields = ['email', 'password'];
        $email = '';
        $password = '';
        foreach($raw_fields as $id => $field) {
            if(in_array($id, $post_fields)) {
                $$id = $field['value'];
                unset($raw_fields[$id]);
            }
        }

        Common::debug(['mail' => $email, 'pass' => $password]);
    }

    public function register_settings_section($form): void
    {
        $form->start_controls_section(
            'section_login',
            [
                'label' => esc_html__( sprintf('Login to %s', get_bloginfo()), 'orion' ),
                'condition' => [
                    'submit_actions' => $this->get_name(),
                ],
            ]
        );

        $form->add_control(
            'orion_login_redirect_to',
            [
                'label' => esc_html('Redirect to', 'orion'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $form->end_controls_section();
    }

    public function on_export($element)
    {
        // TODO: Implement on_export() method.
    }
}