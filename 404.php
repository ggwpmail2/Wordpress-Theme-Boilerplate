<?php
get_header();
?>

<main class="site-main error-404">
    <div class="container">
        <div class="error-content">
            <h1 class="error-title">404</h1>
            <h2 class="error-subtitle">Страница не найдена</h2>
            <p class="error-text">К сожалению, запрашиваемая страница не существует.</p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="button">
                Вернуться на главную
            </a>
        </div>
    </div>
</main>

<?php
get_footer();
