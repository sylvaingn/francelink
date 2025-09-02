<?php get_header(); ?>

    <div class="page-404 large-content">
        <div class="container">
            <div class="page-404--wrapper">
                <h1 class="title big-title"><?php echo __('404', TEXT_DOMAIN); ?></h1>
                <p class="text-center"><?php echo __('Désolé mais cette page n\'est pas disponible...', TEXT_DOMAIN); ?></p>

                <div class="btn--wrapper">
                    <a href="<?php echo get_site_url(); ?>"
                       class="btn btn-primary"><?php echo __('Revenir à la page d\'accueil', TEXT_DOMAIN); ?></a>
                    
                    <?php if ( get_post_type_archive_link('faq' ) ): ?>
                    <a href="<?php echo get_post_type_archive_link('faq' ); ?>"
                       class="btn"><?php echo __('Visiter la FAQ', TEXT_DOMAIN); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php get_footer();