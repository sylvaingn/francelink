</main>

<footer id="colophon" class="gradient-bg">
    <div class="gradients-container">
        <div class="g1"></div>
        <div class="g2"></div>
        <div class="g3"></div>
        <div class="g4"></div>
        <div class="g5"></div>
        <div class="interactive"></div>
    </div>
    <div class="colophon--infos">
        <div class="container container-xxlarge">
            <div class="colophon--wrapper">
                <div class="footer--infos">
                    <a href="<?php echo get_home_url(); ?>" class="site-logo masked"
                       style="--logo-url:url('<?php echo getCustomLogoUrl(); ?>');">
                    </a>
                    <a href="https://status.francelink.net" target="_blank" rel="noopener"
                       class="btn status-link"><?php echo __("Notre page de status", TEXT_DOMAIN) ?></a>
                </div>
                <div class="footer--links">
                    <?php $menus = [
                        'menu-footer',
                        'menu-footer-1',
                        'menu-footer-2'
                    ]; ?>

                    <?php foreach ($menus as $menu): ?>
                        <?php if (has_nav_menu($menu)): ?>
                            <div class="links--menu">
                                <div class="title subtitle"><?php echo wp_get_nav_menu_name($menu) ?></div>
                                <?php
                                wp_nav_menu(array(
                                    'theme_location' => $menu,
                                    'container' => false,
                                    'menu_class' => '',
                                    'items_wrap' => '<nav><ul class="contentify-menu menu menu-footer">%3$s</ul></nav>',
                                ));
                                ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="colophon--mentions">
        <div class="container container-xxlarge">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'menu-mentions',
                'container' => false,
                'menu_class' => '',
                'items_wrap' => '<nav><ul class="contentify-menu menu menu-mentions">%3$s</ul></nav>',
            ));
            ?>
        </div>
    </div>
</footer>

<?php
wp_footer();
?>
</body>

</html>