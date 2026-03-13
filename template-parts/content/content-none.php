<div class="no-content">
    <h2>Ничего не найдено</h2>
    <p>К сожалению, по вашему запросу ничего не найдено. Попробуйте изменить параметры поиска.</p>

    <?php if (is_search()): ?>
        <?php get_search_form(); ?>
    <?php else: ?>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="button">
            Вернуться на главную
        </a>
    <?php endif; ?>
</div>