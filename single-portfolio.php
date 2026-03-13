<?php
get_header();
?>

<main class="site-main portfolio-single">
    <?php
    while (have_posts()):
        the_post();
        ?>
        <article <?php post_class('portfolio-item'); ?>>
            <div class="container">
                <header class="portfolio-header">
                    <h1 class="portfolio-title">
                        <?php the_title(); ?>
                    </h1>

                    <?php
                    $terms = get_the_terms(get_the_ID(), 'portfolio_category');
                    if ($terms && !is_wp_error($terms)):
                        ?>
                        <div class="portfolio-categories">
                            <?php foreach ($terms as $term): ?>
                                <a href="<?php echo esc_url(get_term_link($term)); ?>" class="portfolio-category">
                                    <?php echo esc_html($term->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </header>

                <?php if (has_post_thumbnail()): ?>
                    <div class="portfolio-featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="portfolio-content">
                    <?php the_content(); ?>
                </div>

                <nav class="portfolio-navigation">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    ?>

                    <?php if ($prev_post): ?>
                        <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="nav-previous">
                            <span class="nav-label">Предыдущий проект</span>
                            <span class="nav-title">
                                <?php echo esc_html(get_the_title($prev_post)); ?>
                            </span>
                        </a>
                    <?php endif; ?>

                    <?php if ($next_post): ?>
                        <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="nav-next">
                            <span class="nav-label">Следующий проект</span>
                            <span class="nav-title">
                                <?php echo esc_html(get_the_title($next_post)); ?>
                            </span>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
        </article>
        <?php
    endwhile;
    ?>
</main>

<?php
get_footer();
