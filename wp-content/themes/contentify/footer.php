</main>

<footer id="colophon">
    <div class="container container-xxlarge">
        <div class="footer--body">
            <div class="body--header">
                <div class="header--infos">
                    <a href="<?php echo get_home_url(); ?>" class="site-logo"
                       style="--logo-url:url('<?php echo getCustomLogoUrl(); ?>');">
                    </a>
                    <a href="https://status.francelink.net" target="_blank" rel="noopener"
                       class="btn"><?php echo __("Notre page de status", TEXT_DOMAIN) ?></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php
wp_footer();
?>
</body>

</html>