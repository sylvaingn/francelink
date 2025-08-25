</main>

<footer id="colophon">
    <div class="container container-xxlarge">
        <div class="footer--body">
            <div class="body--header">
                <div class="header--infos">
                    <a href="<?php echo get_home_url(); ?>" class="site-logo"
                       style="--logo-url:url('<?php echo getCustomLogoUrl(); ?>');">
                    </a>
                </div>
                <div class="header--call-to-actions">
                    <a href="#" class="btn btn-full"><?php echo __("Newsletter", TEXT_DOMAIN) ?></a>

                    <?php
                    $billeterie_link = get_field('billeterie-page', 'options');

                    if (isset($billeterie_link) && $billeterie_link != ''): ?>
                        <a href="<?php echo $billeterie_link; ?>"
                           class="btn"><?php echo __("Billeterie", TEXT_DOMAIN) ?></a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="body--links">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'menu-footer',
                    'container' => false,
                    'menu_class' => '',
                    'items_wrap' => '<ul class="menu-footer">%3$s</ul>',
                ));
                ?>
            </div>
            <div class="body--footer">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'menu-mentions',
                    'menu_class' => 'menu-mentions',
                ));
                ?>
            </div>
        </div>
    </div>
</footer>

<?php
wp_footer();
?>
</body>

</html>