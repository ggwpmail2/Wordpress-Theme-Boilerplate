<div class="container">
    <div class="header-inner">
        <div class="site-branding">
            <?php if (has_custom_logo()): ?>
                <?php the_custom_logo(); ?>
            <?php else: ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-title">
                    <?php bloginfo('name'); ?>
                </a>
            <?php endif; ?>
        </div>

        <nav class="main-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'header-menu',
                'container' => false,
                'menu_class' => 'nav-menu',
                'fallback_cb' => false
            ));
            ?>
        </nav>

        <button class="mobile-menu-toggle" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <nav class="mobile-navigation">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'mobile-menu',
            'container' => false,
            'menu_class' => 'mobile-menu',
            'fallback_cb' => false
        ));
        ?>
    </nav>
</div>