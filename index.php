<?php
get_header();
?>

<main class="site-main blog">
    <div class="container">
        <?php if (have_posts()): ?>
            <div class="posts-grid">
                <?php while (have_posts()):
                    the_post(); ?>
                    <?php get_template_part('template-parts/content/content'); ?>
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
