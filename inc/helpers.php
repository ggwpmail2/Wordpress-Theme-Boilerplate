<?php

function theme_pagination()
{
    global $wp_query;

    if ($wp_query->max_num_pages <= 1) {
        return;
    }

    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max = intval($wp_query->max_num_pages);

    if ($paged >= 1) {
        $links[] = $paged;
    }

    if ($paged >= 3) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if (($paged + 2) <= $max) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div class="pagination">';

    if (get_previous_posts_link()) {
        printf('<a href="%s">%s</a>', get_previous_posts_page_link(), '&laquo;');
    }

    if (!in_array(1, $links)) {
        $class = 1 == $paged ? ' class="active"' : '';
        printf('<a href="%s"%s>%s</a>', esc_url(get_pagenum_link(1)), $class, '1');

        if (!in_array(2, $links)) {
            echo '<span>...</span>';
        }
    }

    sort($links);
    foreach ((array) $links as $link) {
        $class = $paged == $link ? ' class="active"' : '';
        printf('<a href="%s"%s>%s</a>', esc_url(get_pagenum_link($link)), $class, $link);
    }

    if (!in_array($max, $links)) {
        if (!in_array($max - 1, $links)) {
            echo '<span>...</span>';
        }

        $class = $paged == $max ? ' class="active"' : '';
        printf('<a href="%s"%s>%s</a>', esc_url(get_pagenum_link($max)), $class, $max);
    }

    if (get_next_posts_link()) {
        printf('<a href="%s">%s</a>', get_next_posts_page_link(), '&raquo;');
    }

    echo '</div>';
}

function get_inline_svg($file_path)
{
    if (empty($file_path)) {
        return '';
    }

    $full_path = get_template_directory() . '/' . ltrim($file_path, '/');

    if (!file_exists($full_path) || !is_readable($full_path)) {
        return '';
    }

    $svg_content = file_get_contents($full_path);

    if ($svg_content === false) {
        return '';
    }

    return $svg_content;
}

function format_date($date)
{
    if (empty($date)) {
        return '';
    }

    $timestamp = is_numeric($date) ? $date : strtotime($date);

    if ($timestamp === false) {
        return '';
    }

    $months = array(
        1 => 'января',
        2 => 'февраля',
        3 => 'марта',
        4 => 'апреля',
        5 => 'мая',
        6 => 'июня',
        7 => 'июля',
        8 => 'августа',
        9 => 'сентября',
        10 => 'октября',
        11 => 'ноября',
        12 => 'декабря'
    );

    $day = date('j', $timestamp);
    $month = $months[(int) date('n', $timestamp)];
    $year = date('Y', $timestamp);

    return $day . ' ' . $month . ' ' . $year;
}

function get_theme_image($attachment_id, $size = 'full', $class = '')
{
    if (empty($attachment_id) || !is_numeric($attachment_id)) {
        return '';
    }

    $attachment_id = absint($attachment_id);

    if (!wp_attachment_is_image($attachment_id)) {
        return '';
    }

    $image = wp_get_attachment_image($attachment_id, $size, false, ['class' => $class]);

    if (empty($image)) {
        return '';
    }

    return $image;
}

function theme_breadcrumbs()
{
    if (is_front_page()) {
        return;
    }

    $separator = '<span class="breadcrumb-separator">/</span>';
    $home_title = 'Главная';

    echo '<nav class="breadcrumbs">';
    echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html($home_title) . '</a>';

    if (is_home()) {
        echo $separator;
        echo '<span class="breadcrumb-current">' . esc_html(get_the_title(get_option('page_for_posts'))) . '</span>';
    } elseif (is_category()) {
        $category = get_queried_object();
        if ($category->parent) {
            $parent_cats = array();
            $parent_id = $category->parent;
            while ($parent_id) {
                $parent = get_category($parent_id);
                $parent_cats[] = $parent;
                $parent_id = $parent->parent;
            }
            $parent_cats = array_reverse($parent_cats);
            foreach ($parent_cats as $parent) {
                echo $separator;
                echo '<a href="' . esc_url(get_category_link($parent->term_id)) . '">' . esc_html($parent->name) . '</a>';
            }
        }
        echo $separator;
        echo '<span class="breadcrumb-current">' . esc_html($category->name) . '</span>';
    } elseif (is_single()) {
        $post_type = get_post_type();
        if ($post_type === 'post') {
            $categories = get_the_category();
            if ($categories) {
                $category = $categories[0];
                if ($category->parent) {
                    $parent_cats = array();
                    $parent_id = $category->parent;
                    while ($parent_id) {
                        $parent = get_category($parent_id);
                        $parent_cats[] = $parent;
                        $parent_id = $parent->parent;
                    }
                    $parent_cats = array_reverse($parent_cats);
                    foreach ($parent_cats as $parent) {
                        echo $separator;
                        echo '<a href="' . esc_url(get_category_link($parent->term_id)) . '">' . esc_html($parent->name) . '</a>';
                    }
                }
                echo $separator;
                echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
            }
        } else {
            $post_type_object = get_post_type_object($post_type);
            if ($post_type_object && $post_type_object->has_archive) {
                echo $separator;
                echo '<a href="' . esc_url(get_post_type_archive_link($post_type)) . '">' . esc_html($post_type_object->labels->name) . '</a>';
            }
        }
        echo $separator;
        echo '<span class="breadcrumb-current">' . esc_html(get_the_title()) . '</span>';
    } elseif (is_page()) {
        $parent_id = wp_get_post_parent_id(get_the_ID());
        if ($parent_id) {
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_post($parent_id);
                $breadcrumbs[] = $page;
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) {
                echo $separator;
                echo '<a href="' . esc_url(get_permalink($crumb->ID)) . '">' . esc_html($crumb->post_title) . '</a>';
            }
        }
        echo $separator;
        echo '<span class="breadcrumb-current">' . esc_html(get_the_title()) . '</span>';
    } elseif (is_tag()) {
        $tag = get_queried_object();
        echo $separator;
        echo '<span class="breadcrumb-current">' . esc_html($tag->name) . '</span>';
    } elseif (is_author()) {
        $author = get_queried_object();
        echo $separator;
        echo '<span class="breadcrumb-current">' . esc_html($author->display_name) . '</span>';
    } elseif (is_day()) {
        echo $separator;
        echo '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a>';
        echo $separator;
        echo '<a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '">' . esc_html(get_the_time('F')) . '</a>';
        echo $separator;
        echo '<span class="breadcrumb-current">' . esc_html(get_the_time('d')) . '</span>';
    } elseif (is_month()) {
        echo $separator;
        echo '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a>';
        echo $separator;
        echo '<span class="breadcrumb-current">' . esc_html(get_the_time('F')) . '</span>';
    } elseif (is_year()) {
        echo $separator;
        echo '<span class="breadcrumb-current">' . esc_html(get_the_time('Y')) . '</span>';
    } elseif (is_archive()) {
        $post_type = get_post_type();
        if ($post_type) {
            $post_type_object = get_post_type_object($post_type);
            if ($post_type_object) {
                echo $separator;
                echo '<span class="breadcrumb-current">' . esc_html($post_type_object->labels->name) . '</span>';
            }
        }
    } elseif (is_search()) {
        echo $separator;
        echo '<span class="breadcrumb-current">Поиск: ' . esc_html(get_search_query()) . '</span>';
    } elseif (is_404()) {
        echo $separator;
        echo '<span class="breadcrumb-current">Страница не найдена</span>';
    }

    echo '</nav>';
}

function transliterate_text($text)
{
    $iso9_table = array(
        'А' => 'A',
        'Б' => 'B',
        'В' => 'V',
        'Г' => 'G',
        'Д' => 'D',
        'Е' => 'E',
        'Ё' => 'Yo',
        'Ж' => 'Zh',
        'З' => 'Z',
        'И' => 'I',
        'Й' => 'J',
        'К' => 'K',
        'Л' => 'L',
        'М' => 'M',
        'Н' => 'N',
        'О' => 'O',
        'П' => 'P',
        'Р' => 'R',
        'С' => 'S',
        'Т' => 'T',
        'У' => 'U',
        'Ф' => 'F',
        'Х' => 'H',
        'Ц' => 'C',
        'Ч' => 'Ch',
        'Ш' => 'Sh',
        'Щ' => 'Shh',
        'Ъ' => '',
        'Ы' => 'Y',
        'Ь' => '',
        'Э' => 'E',
        'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a',
        'б' => 'b',
        'в' => 'v',
        'г' => 'g',
        'д' => 'd',
        'е' => 'e',
        'ё' => 'yo',
        'ж' => 'zh',
        'з' => 'z',
        'и' => 'i',
        'й' => 'j',
        'к' => 'k',
        'л' => 'l',
        'м' => 'm',
        'н' => 'n',
        'о' => 'o',
        'п' => 'p',
        'р' => 'r',
        'с' => 's',
        'т' => 't',
        'у' => 'u',
        'ф' => 'f',
        'х' => 'h',
        'ц' => 'c',
        'ч' => 'ch',
        'ш' => 'sh',
        'щ' => 'shh',
        'ъ' => '',
        'ы' => 'y',
        'ь' => '',
        'э' => 'e',
        'ю' => 'yu',
        'я' => 'ya',
        'Є' => 'Ye',
        'І' => 'I',
        'Ї' => 'Yi',
        'Ґ' => 'G',
        'є' => 'ye',
        'і' => 'i',
        'ї' => 'yi',
        'ґ' => 'g'
    );

    return strtr($text, $iso9_table);
}

function transliterate_slug($title, $raw_title = '', $context = 'save')
{
    if ($context === 'save' && !empty($raw_title)) {
        $title = transliterate_text($raw_title);
    }
    return $title;
}
add_filter('sanitize_title', 'transliterate_slug', 0, 3);

function transliterate_filename($filename)
{
    $info = pathinfo($filename);
    $ext = isset($info['extension']) ? '.' . $info['extension'] : '';
    $name = basename($filename, $ext);

    $name = transliterate_text($name);
    $name = str_replace(' ', '-', $name);
    $name = preg_replace('/[^A-Za-z0-9\-_]/', '', $name);
    $name = preg_replace('/-+/', '-', $name);
    $name = trim($name, '-');

    if (empty($name)) {
        $name = 'file-' . time();
    }

    return $name . $ext;
}
add_filter('sanitize_file_name', 'transliterate_filename', 10);

function transliterate_term_slug($slug, $term, $original_slug)
{
    if (!empty($original_slug)) {
        $slug = transliterate_text($original_slug);
        $slug = sanitize_title($slug);
    }
    return $slug;
}
add_filter('pre_term_slug', 'transliterate_term_slug', 10, 3);
