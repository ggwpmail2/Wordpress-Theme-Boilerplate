<?php
get_header();
?>

<main class="site-main single-page">
    <?php
    while (have_posts()):
        the_post();
        ?>
        <article <?php post_class(); ?>>
            <div class="container">
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </div>
        </article>
        <?php
    endwhile;
    ?>
</main>

<?php
get_footer();
