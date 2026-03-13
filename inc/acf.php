<?php

add_action('acf/init', 'register_acf_options_pages');
function register_acf_options_pages()
{
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title' => 'Глобальные настройки',
            'menu_slug' => 'global-settings'
        ));

        acf_add_options_sub_page(array(
            'page_title' => 'Контакты',
            'parent_slug' => 'global-settings'
        ));

        acf_add_options_sub_page(array(
            'page_title' => 'Социальные сети',
            'parent_slug' => 'global-settings'
        ));
    }
}
