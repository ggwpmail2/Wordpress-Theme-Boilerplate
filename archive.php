<?php
get_header();
?>

<main class="site-main archive">
    <div class="container">
        <?php if (have_posts()): ?>
            <header class="archive-header">
                <?php the_archive_title('<h1 class="archive-title">', '</h1>'); ?>
                <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
            </header>

            <div class="posts-grid">
                <?php while (have_posts()):
                    the_post(); ?>
                    <?php get_template_part('template-parts/content/content', get_post_type()); ?>
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
