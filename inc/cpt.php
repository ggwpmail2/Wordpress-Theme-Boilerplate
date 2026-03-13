<?php

function register_custom_post_types()
{
    register_post_type('portfolio', array(
        'labels' => array(
            'name' => 'Портфолио',
            'singular_name' => 'Проект',
            'add_new' => 'Добавить проект',
            'add_new_item' => 'Добавить новый проект',
            'edit_item' => 'Редактировать проект',
            'new_item' => 'Новый проект',
            'view_item' => 'Посмотреть проект',
            'search_items' => 'Найти проект',
            'not_found' => 'Проектов не найдено',
            'not_found_in_trash' => 'В корзине проектов не найдено',
            'menu_name' => 'Портфолио'
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'portfolio'),
        'show_in_rest' => false
    ));
}

add_action('init', 'register_custom_post_types');

function register_custom_taxonomies()
{
    register_taxonomy('portfolio_category', 'portfolio', array(
        'labels' => array(
            'name' => 'Категории портфолио',
            'singular_name' => 'Категория',
            'search_items' => 'Найти категорию',
            'all_items' => 'Все категории',
            'parent_item' => 'Родительская категория',
            'parent_item_colon' => 'Родительская категория:',
            'edit_item' => 'Редактировать категорию',
            'update_item' => 'Обновить категорию',
            'add_new_item' => 'Добавить новую категорию',
            'new_item_name' => 'Название новой категории',
            'menu_name' => 'Категории'
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'portfolio-category'),
        'show_in_rest' => false
    ));
}

add_action('init', 'register_custom_taxonomies');
