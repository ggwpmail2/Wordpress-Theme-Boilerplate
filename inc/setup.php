<?php

function theme_setup()
{
    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');

    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption'
    ));

    if (!isset($GLOBALS['content_width'])) {
        $GLOBALS['content_width'] = 1200;
    }

    register_nav_menus(array(
        'header-menu' => 'Header',
        'footer-menu' => 'Footer',
        'mobile-menu' => 'Mobile'
    ));
}
add_action('after_setup_theme', 'theme_setup');

function theme_widgets_init()
{
    register_sidebar(array(
        'id' => 'footer-sidebar',
        'name' => 'Footer Widgets',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}
add_action('widgets_init', 'theme_widgets_init');
