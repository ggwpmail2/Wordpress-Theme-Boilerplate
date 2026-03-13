<?php
get_header();
?>

<main class="site-main single-post">
    <?php
    while (have_posts()):
        the_post();
        ?>
        <article <?php post_class(); ?>>
            <div class="container">
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>

                    <div class="entry-meta">
                        <time datetime="<?php echo get_the_date('c'); ?>">
                            <?php echo get_the_date(); ?>
                        </time>

                        <?php if (has_category()): ?>
                            <span class="entry-categories">
                                <?php the_category(', '); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </header>

                <?php if (has_post_thumbnail()): ?>
                    <div class="entry-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <?php if (has_tag()): ?>
                    <footer class="entry-footer">
                        <div class="entry-tags">
                            <?php the_tags('', ' '); ?>
                        </div>
                    </footer>
                <?php endif; ?>
            </div>
        </article>
        <?php
    endwhile;
    ?>
</main>

<?php
get_footer();
