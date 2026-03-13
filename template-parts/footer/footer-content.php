<div class="container">
    <div class="footer-inner">
        <?php if (is_active_sidebar('footer-sidebar')): ?>
            <div class="footer-widgets">
                <?php dynamic_sidebar('footer-sidebar'); ?>
            </div>
        <?php endif; ?>

        <?php if (has_nav_menu('footer-menu')): ?>
            <nav class="footer-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer-menu',
                    'container' => false,
                    'menu_class' => 'footer-menu',
                    'depth' => 1
                ));
                ?>
            </nav>
        <?php endif; ?>

        <div class="footer-bottom">
            <p class="copyright">
                &copy;
                <?php echo date('Y'); ?>
                <?php bloginfo('name'); ?>
            </p>
        </div>
    </div>
</div>