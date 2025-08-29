<?php get_header(); ?>

    <div id="home-top-page" class="large-content">
        <div class="container container-small">
            <div class="home-top-page--wrapper">
                <h1><?php echo __('Espace documentation & support', TEXT_DOMAIN); ?></h1>
                <div class="content">
                    <p>Retrouvez en un seul endroit tous nos guides, tutoriels et notes de mise à jour pour mieux
                        utiliser nos services.</p>
                    <p>Le site <a href="https://status.francelink.net" target="_blank">status.francelink.net</a> continue de vous
                        informer en temps réel sur l’état de nos services et incidents.</p>
                </div>
                <a href="<?php echo get_post_type_archive_link('faq') ?>"
                   class="btn"><?php echo __('Accéder à nos FAQ', TEXT_DOMAIN); ?></a>
            </div>
        </div>
    </div>
<?php //the_content(); ?>

<?php get_footer();
