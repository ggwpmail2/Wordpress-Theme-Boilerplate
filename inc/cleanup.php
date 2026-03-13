<?php

function add_theme_settings_page()
{
    add_theme_page(
        'Настройки темы',
        'Настройки темы',
        'manage_options',
        'theme-settings',
        'render_theme_settings_page'
    );
}
add_action('admin_menu', 'add_theme_settings_page');

function register_theme_settings()
{
    register_setting(
        'theme_settings_group',
        'theme_settings',
        array(
            'sanitize_callback' => 'sanitize_theme_settings',
            'default' => array()
        )
    );
}
add_action('admin_init', 'register_theme_settings');

function sanitize_theme_settings($input)
{
    if (!current_user_can('manage_options')) {
        return get_option('theme_settings', array());
    }

    $allowed_settings = array(
        'remove_category_base',
        'disable_author_archives',
        'remove_wp_version',
        'disable_emoji',
        'remove_rsd_link',
        'remove_wlwmanifest',
        'remove_shortlink',
        'remove_rest_api_links',
        'disable_rss_feeds',
        'disable_oembed',
        'disable_xmlrpc',
        'reduce_heartbeat',
        'disable_comments',
        'disable_gutenberg',
        'disable_gutenberg_css',
        'disable_separate_block_assets',
        'disable_dashicons_frontend',
        'disable_jquery',
        'disable_jquery_migrate',
        'disable_image_sizes',
        'disable_search',
        'disable_attachment_pages',
        'remove_query_strings'
    );

    $sanitized = array();
    foreach ($allowed_settings as $setting) {
        if (isset($input[$setting])) {
            $sanitized[$setting] = '1';
        }
    }

    $old_options = get_option('theme_settings', array());
    if (
        (!empty($sanitized['remove_category_base']) && empty($old_options['remove_category_base'])) ||
        (empty($sanitized['remove_category_base']) && !empty($old_options['remove_category_base']))
    ) {
        flush_rewrite_rules();
    }

    return $sanitized;
}

function render_theme_settings_page()
{
    if (!current_user_can('manage_options')) {
        wp_die('У вас нет прав для доступа к этой странице');
    }

    if (isset($_POST['theme_settings_reset'])) {
        check_admin_referer('theme_settings_action', 'theme_settings_nonce');
        delete_option('theme_settings');
        flush_rewrite_rules();
        echo '<div class="notice notice-success"><p>Настройки сброшены</p></div>';
    }

    $options = get_option('theme_settings', array());

    $settings_labels = array(
        'remove_category_base' => 'Удалить /category/ из URL постов',
        'disable_author_archives' => 'Отключить архивы авторов',
        'remove_wp_version' => 'Удалить версию WordPress из head',
        'disable_emoji' => 'Отключить Emoji скрипты и стили',
        'remove_rsd_link' => 'Удалить RSD link из head',
        'remove_wlwmanifest' => 'Удалить wlwmanifest link из head',
        'remove_shortlink' => 'Удалить shortlink из head',
        'remove_rest_api_links' => 'Удалить REST API links из head',
        'disable_rss_feeds' => 'Отключить RSS feeds',
        'disable_oembed' => 'Отключить oEmbed',
        'disable_xmlrpc' => 'Отключить XML-RPC',
        'reduce_heartbeat' => 'Уменьшить частоту Heartbeat API',
        'disable_comments' => 'Отключить систему комментариев',
        'disable_gutenberg' => 'Отключить Gutenberg редактор',
        'disable_gutenberg_css' => 'Отключить Gutenberg CSS',
        'disable_separate_block_assets' => 'Отключить раздельную загрузку CSS блоков Gutenberg',
        'disable_dashicons_frontend' => 'Отключить Dashicons на frontend',
        'disable_jquery' => 'Отключить jQuery (осторожно: может сломать плагины)',
        'disable_jquery_migrate' => 'Отключить jQuery Migrate',
        'disable_image_sizes' => 'Отключить автоматическую генерацию размеров изображений',
        'disable_search' => 'Отключить поиск по сайту',
        'disable_attachment_pages' => 'Отключить страницы вложений',
        'remove_query_strings' => 'Удалить query strings из CSS/JS'
    );
    ?>
    <div class="wrap">
        <h1>Настройки темы</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('theme_settings_group');
            do_settings_sections('theme-settings');
            ?>
            <table class="form-table">
                <?php foreach ($settings_labels as $key => $label): ?>
                    <tr>
                        <th scope="row">
                            <?php echo esc_html($label); ?>
                        </th>
                        <td>
                            <input type="checkbox" name="theme_settings[<?php echo esc_attr($key); ?>]" value="1" <?php checked(!empty($options[$key])); ?>>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php submit_button('Сохранить настройки'); ?>
        </form>
        <form method="post" action="" style="margin-top: 20px;">
            <?php wp_nonce_field('theme_settings_action', 'theme_settings_nonce'); ?>
            <?php submit_button('Сбросить все настройки', 'secondary', 'theme_settings_reset', false); ?>
        </form>
    </div>
    <?php
}

function get_cached_theme_settings()
{
    static $cached_options = null;
    if ($cached_options === null) {
        $cached_options = get_option('theme_settings', array());
    }
    return $cached_options;
}

function cleanup_remove_category_base($rules)
{
    $new_rules = array();
    foreach ($rules as $key => $value) {
        $new_rules[str_replace('category/', '', $key)] = $value;
    }
    return $new_rules;
}

function cleanup_category_link($link)
{
    return str_replace('/category/', '/', $link);
}

function cleanup_disable_author_archives()
{
    if (is_author()) {
        wp_redirect(home_url(), 301);
        exit;
    }
}

function cleanup_disable_attachment_pages()
{
    if (is_attachment()) {
        global $post;
        if ($post && $post->post_parent) {
            wp_redirect(get_permalink($post->post_parent), 301);
        } else {
            wp_redirect(home_url(), 301);
        }
        exit;
    }
}

function cleanup_disable_search()
{
    if (is_search()) {
        wp_redirect(home_url(), 301);
        exit;
    }
}

function cleanup_disable_feeds()
{
    wp_redirect(home_url(), 301);
    exit;
}

function cleanup_heartbeat_settings($settings)
{
    $settings['interval'] = 60;
    return $settings;
}

function cleanup_disable_comments_admin()
{
    remove_post_type_support('post', 'comments');
    remove_post_type_support('page', 'comments');
}

function cleanup_remove_comments_menu()
{
    remove_menu_page('edit-comments.php');
}

function cleanup_dequeue_gutenberg_css()
{
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-blocks-style');
    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('global-styles');
}

function cleanup_dequeue_dashicons()
{
    if (!is_user_logged_in()) {
        wp_deregister_style('dashicons');
    }
}

function cleanup_dequeue_jquery()
{
    if (!is_admin() && !is_customize_preview()) {
        global $wp_scripts;
        $jquery_dependents = array();

        if (isset($wp_scripts->registered)) {
            foreach ($wp_scripts->registered as $handle => $script) {
                if (isset($script->deps) && in_array('jquery', $script->deps)) {
                    $jquery_dependents[] = $handle;
                }
            }
        }

        if (empty($jquery_dependents)) {
            wp_deregister_script('jquery');
        }
    }
}

function cleanup_remove_jquery_migrate($scripts)
{
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}

function cleanup_disable_image_sizes($sizes)
{
    unset($sizes['thumbnail']);
    unset($sizes['medium']);
    unset($sizes['medium_large']);
    unset($sizes['large']);
    return $sizes;
}

function cleanup_remove_query_strings($src)
{
    if ($src) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}

function apply_cleanup_functions()
{
    $options = get_cached_theme_settings();

    if (!empty($options['remove_category_base'])) {
        add_filter('category_rewrite_rules', 'cleanup_remove_category_base');
        add_filter('category_link', 'cleanup_category_link');
    }

    if (!empty($options['disable_author_archives'])) {
        add_action('template_redirect', 'cleanup_disable_author_archives');
    }

    if (!empty($options['disable_attachment_pages'])) {
        add_action('template_redirect', 'cleanup_disable_attachment_pages');
    }

    if (!empty($options['disable_search'])) {
        add_action('template_redirect', 'cleanup_disable_search');
        add_filter('get_search_form', '__return_empty_string');
    }

    if (!empty($options['remove_wp_version'])) {
        remove_action('wp_head', 'wp_generator');
        add_filter('the_generator', '__return_empty_string');
    }

    if (!empty($options['disable_emoji'])) {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('tiny_mce_plugins', function ($plugins) {
            return is_array($plugins) ? array_diff($plugins, array('wpemoji')) : array();
        });
        add_filter('wp_resource_hints', function ($urls, $relation_type) {
            if ('dns-prefetch' === $relation_type) {
                $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/');
                $urls = array_diff($urls, array($emoji_svg_url));
            }
            return $urls;
        }, 10, 2);
    }

    if (!empty($options['remove_rsd_link'])) {
        remove_action('wp_head', 'rsd_link');
    }

    if (!empty($options['remove_wlwmanifest'])) {
        remove_action('wp_head', 'wlwmanifest_link');
    }

    if (!empty($options['remove_shortlink'])) {
        remove_action('wp_head', 'wp_shortlink_wp_head');
        remove_action('template_redirect', 'wp_shortlink_header', 11);
    }

    if (!empty($options['remove_rest_api_links'])) {
        remove_action('wp_head', 'rest_output_link_wp_head');
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('template_redirect', 'rest_output_link_header', 11);
    }

    if (!empty($options['disable_rss_feeds'])) {
        add_action('do_feed', 'cleanup_disable_feeds', 1);
        add_action('do_feed_rdf', 'cleanup_disable_feeds', 1);
        add_action('do_feed_rss', 'cleanup_disable_feeds', 1);
        add_action('do_feed_rss2', 'cleanup_disable_feeds', 1);
        add_action('do_feed_atom', 'cleanup_disable_feeds', 1);
        add_action('do_feed_rss2_comments', 'cleanup_disable_feeds', 1);
        add_action('do_feed_atom_comments', 'cleanup_disable_feeds', 1);
    }

    if (!empty($options['disable_oembed'])) {
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
        add_filter('embed_oembed_discover', '__return_false');
        add_filter('oembed_response_data', '__return_false');
    }

    if (!empty($options['disable_xmlrpc'])) {
        add_filter('xmlrpc_enabled', '__return_false');
        add_filter('wp_headers', function ($headers) {
            unset($headers['X-Pingback']);
            return $headers;
        });
    }

    if (!empty($options['reduce_heartbeat'])) {
        add_filter('heartbeat_settings', 'cleanup_heartbeat_settings');
    }

    if (!empty($options['disable_comments'])) {
        add_action('admin_init', 'cleanup_disable_comments_admin');
        add_filter('comments_open', '__return_false', 20, 2);
        add_filter('pings_open', '__return_false', 20, 2);
        add_filter('comments_array', '__return_empty_array', 10, 2);
        add_action('admin_menu', 'cleanup_remove_comments_menu');
        add_action('init', function () {
            if (is_admin_bar_showing()) {
                remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
            }
        });
    }

    if (!empty($options['disable_gutenberg'])) {
        add_filter('use_block_editor_for_post', '__return_false', 10);
        add_filter('use_block_editor_for_post_type', '__return_false', 10);
    }

    if (!empty($options['disable_gutenberg_css'])) {
        add_action('wp_enqueue_scripts', 'cleanup_dequeue_gutenberg_css', 100);
    }

    if (!empty($options['disable_dashicons_frontend'])) {
        add_action('wp_enqueue_scripts', 'cleanup_dequeue_dashicons');
    }

    if (!empty($options['disable_jquery'])) {
        add_action('wp_enqueue_scripts', 'cleanup_dequeue_jquery', 100);
    }

    if (!empty($options['disable_jquery_migrate'])) {
        add_action('wp_default_scripts', 'cleanup_remove_jquery_migrate');
    }

    if (!empty($options['disable_image_sizes'])) {
        add_filter('intermediate_image_sizes_advanced', 'cleanup_disable_image_sizes');
        add_filter('big_image_size_threshold', '__return_false');
    }

    if (!empty($options['remove_query_strings'])) {
        add_filter('script_loader_src', 'cleanup_remove_query_strings', 15);
        add_filter('style_loader_src', 'cleanup_remove_query_strings', 15);
    }
}
add_action('init', 'apply_cleanup_functions');

$theme_options = get_option('theme_settings', array());
if (!empty($theme_options['disable_separate_block_assets'])) {
    add_filter('should_load_separate_core_block_assets', '__return_false');
}
