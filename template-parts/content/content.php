<article <?php post_class('post-item'); ?>>
    <?php if (has_post_thumbnail()): ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium'); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="post-content">
        <header class="post-header">
            <h2 class="post-title">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h2>

            <div class="post-meta">
                <time datetime="<?php echo get_the_date('c'); ?>">
                    <?php echo get_the_date(); ?>
                </time>

                <?php if (has_category()): ?>
                    <span class="post-categories">
                        <?php the_category(', '); ?>
                    </span>
                <?php endif; ?>
            </div>
        </header>

        <?php if (has_excerpt()): ?>
            <div class="post-excerpt">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>

        <a href="<?php the_permalink(); ?>" class="read-more">
            Читать далее
        </a>
    </div>
</article>