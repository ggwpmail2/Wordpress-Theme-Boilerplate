<?php
get_header();
?>

<main class="site-main search-results">
    <div class="container">
        <?php if (have_posts()): ?>
            <header class="search-header">
                <h1 class="search-title">
                    Результаты поиска:
                    <?php echo esc_html(get_search_query()); ?>
                </h1>
                <p class="search-count">
                    Найдено результатов:
                    <?php echo $wp_query->found_posts; ?>
                </p>
            </header>

            <div class="search-results-list">
                <?php while (have_posts()):
                    the_post(); ?>
                    <?php get_template_part('template-parts/content/content', 'search'); ?>
                <?php endwhile; ?>
            </div>

            <?php theme_pagination(); ?>
        <?php else: ?>
            <div class="no-results">
                <h1>Ничего не найдено</h1>
                <p>По вашему запросу "
                    <?php echo esc_html(get_search_query()); ?>" ничего не найдено.
                </p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
