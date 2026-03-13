<?php
get_header();
?>

<main class="site-main front-page">
    <?php
    while (have_posts()):
        the_post();
        ?>
        <div class="page-content">
            <?php the_content(); ?>
        </div>
        <?php
    endwhile;
    ?>
</main>

<?php
get_footer();
