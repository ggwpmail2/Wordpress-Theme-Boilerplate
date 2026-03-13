<?php
get_header();
?>

<main class="site-main portfolio-archive">
    <div class="container">
        <?php if (have_posts()): ?>
            <header class="portfolio-header">
                <h1 class="portfolio-title">Портфолио</h1>
            </header>

            <?php
            $terms = get_terms(array(
                'taxonomy' => 'portfolio_category',
                'hide_empty' => true
            ));

            if ($terms && !is_wp_error($terms)):
                ?>
                <div class="portfolio-filters">
                    <button class="filter-button active" data-filter="*">Все</button>
                    <?php foreach ($terms as $term): ?>
                        <button class="filter-button" data-filter=".category-<?php echo esc_attr($term->slug); ?>">
                            <?php echo esc_html($term->name); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="portfolio-grid">
                <?php while (have_posts()):
                    the_post(); ?>
                    <?php get_template_part('template-parts/content/content', 'portfolio'); ?>
                <?php endwhile; ?>
            </div>

            <?php theme_pagination(); ?>
        <?php else: ?>
            <?php get_template_part('template-parts/content/content', 'none'); ?>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
