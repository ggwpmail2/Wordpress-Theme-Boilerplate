<?php
$terms = get_the_terms(get_the_ID(), 'portfolio_category');
$term_classes = '';
if ($terms && !is_wp_error($terms)) {
    $term_slugs = array_map(function ($term) {
        return 'category-' . $term->slug;
    }, $terms);
    $term_classes = implode(' ', $term_slugs);
}
?>

<article <?php post_class('portfolio-item ' . $term_classes); ?>>
    <a href="<?php the_permalink(); ?>" class="portfolio-link">
        <?php if (has_post_thumbnail()): ?>
                <div class="portfolio-thumbnail">
                    <?php the_post_thumbnail('medium_large'); ?>
        <div class="portfolio-overlay">
            <h3 class="portfolio-title">
                <?php the_title(); ?>
            </h3>
            <?php if ($terms && !is_wp_error($terms)): ?>
                <div class="portfolio-categories">
                    <?php foreach ($terms as $term): ?>
                        <span class="portfolio-category">
                            <?php echo esc_html($term->name); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        </div>
    <?php else: ?>
        <div class="portfolio-no-image">
            <h3 class="portfolio-title">
                <?php the_title(); ?>
            </h3>
        </div>
    <?php endif; ?>
    </a>
</article>