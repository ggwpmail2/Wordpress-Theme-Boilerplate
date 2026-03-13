<?php

function enqueue_theme_assets()
{
    wp_enqueue_style(
        'theme-style',
        get_template_directory_uri() . '/assets/css/style.css',
        array(),
        null
    );

    wp_enqueue_script(
        'theme-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        null,
        array(
            'strategy' => 'defer',
            'in_footer' => true
        )
    );

    wp_localize_script(
        'theme-script',
        'themeData',
        array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('theme_nonce')
        )
    );
}
add_action('wp_enqueue_scripts', 'enqueue_theme_assets');


