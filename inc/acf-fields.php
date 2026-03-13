<?php

add_action('acf/include_fields', 'register_acf_field_groups');
function register_acf_field_groups()
{
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_contacts',
        'title' => 'Контакты',
        'fields' => array(
            array(
                'key' => 'field_phone',
                'label' => 'Телефон',
                'name' => 'phone',
                'type' => 'text',
            ),
            array(
                'key' => 'field_email',
                'label' => 'Email',
                'name' => 'email',
                'type' => 'email',
            ),
            array(
                'key' => 'field_address',
                'label' => 'Адрес',
                'name' => 'address',
                'type' => 'textarea',
                'rows' => 3,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-kontakty',
                ),
            ),
        ),
    ));

    acf_add_local_field_group(array(
        'key' => 'group_social',
        'title' => 'Социальные сети',
        'fields' => array(
            array(
                'key' => 'field_facebook',
                'label' => 'Facebook',
                'name' => 'facebook',
                'type' => 'url',
            ),
            array(
                'key' => 'field_instagram',
                'label' => 'Instagram',
                'name' => 'instagram',
                'type' => 'url',
            ),
            array(
                'key' => 'field_twitter',
                'label' => 'Twitter',
                'name' => 'twitter',
                'type' => 'url',
            ),
            array(
                'key' => 'field_youtube',
                'label' => 'YouTube',
                'name' => 'youtube',
                'type' => 'url',
            ),
            array(
                'key' => 'field_linkedin',
                'label' => 'LinkedIn',
                'name' => 'linkedin',
                'type' => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-sotsialnye-seti',
                ),
            ),
        ),
    ));
}
