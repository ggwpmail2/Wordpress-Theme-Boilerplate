<article <?php post_class('search-item'); ?>>
    <header class="search-item-header">
        <h2 class="search-item-title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h2>

        <div class="search-item-meta">
            <span class="post-type">
                <?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?>
            </span>
            <time datetime="<?php echo get_the_date('c'); ?>">
                <?php echo get_the_date(); ?>
            </time>
        </div>
    </header>

    <?php if (has_excerpt()): ?>
        <div class="search-item-excerpt">
            <?php the_excerpt(); ?>
        </div>
    <?php else: ?>
        <div class="search-item-excerpt">
            <?php echo wp_trim_words(get_the_content(), 30); ?>
        </div>
    <?php endif; ?>

    <a href="<?php the_permalink(); ?>" class="search-item-link">
        Подробнее
    </a>
</article>