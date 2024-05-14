<?php

namespace orion\actions\elementor\form_actions;

use orion\helpers\Common;

class Orion_Create_Post extends \ElementorPro\Modules\Forms\Classes\Action_Base {

    public function get_name(): string
    {
        return 'orion-create-edit-post';
    }

    public function get_label(): string
    {
        return esc_html__('Create or Edit post', 'orion');
    }

    public function run($record, $ajax_handler): void
    {
        $settings = $record->get( 'form_settings' );
        $raw_fields = $record->get( 'fields' );
        $post_type = $settings['orion_cep_post_type'];
        $post_status = $settings['orion_cep_post_status'];

        $post_fields = ['post_title', 'post_content'];
        $post_title = '';
        $post_content = '';
        foreach($raw_fields as $id => $field) {
            if(in_array($id, $post_fields)) {
                $$id = $field['value'];
                unset($raw_fields[$id]);
            }
        }

        $post_id = wp_insert_post([
            'post_type' => $post_type,
            'post_status' => $post_status,
            'post_title' => $post_title,
            'post_content' => $post_content,
        ]);

        foreach ( $raw_fields as $id => $field ) {
            switch($field['type']) {
                case 'date':
                    update_field($id, strtotime($field['raw_value']), $post_id);
                    break;
                default:
                    update_field($id, $field['value'], $post_id);
                    break;
            }
        }
    }

    public function register_settings_section($form): void
    {
        $form->start_controls_section(
            'section_create_new_post',
            [
                'label' => esc_html__( 'Create or Edit post', 'orion' ),
                'condition' => [
                    'submit_actions' => $this->get_name(),
                ],
            ]
        );

        $post_types = get_post_types(null, 'object');
        $post_type_options = [];
        foreach($post_types as $post_type) {
            $post_type_options[$post_type->name] = $post_type->label;
        }

        $form->add_control(
            'orion_cep_post_type',
            [
                'label' => esc_html__('Post type', 'orion'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => false,
                'options' => $post_type_options,
                'default' => [ 'post' ],
            ]
        );

        $form->add_control(
            'orion_cep_post_status',
            [
                'label' => esc_html__('Post type', 'orion'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => get_post_statuses(),
                'default' => [ 'draft' ],
            ]
        );

        $form->end_controls_section();
    }

    public function on_export($element)
    {
        // TODO: Implement on_export() method.
    }
}