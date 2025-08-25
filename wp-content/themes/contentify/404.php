<?php get_header(); ?>

    <div class="page-404 large-content">
        <div class="container">
            <div class="page-404--wrapper">
                <h1 class="title menu-title"><?php echo __('404', TEXT_DOMAIN); ?></h1>
                <p class="text-center"><?php echo __('Désolé mais cette page n\'est pas disponible...', TEXT_DOMAIN); ?></p>

                <div class="btn--wrapper">
                    <a href="<?php echo get_site_url(); ?>"
                       class="btn"><?php echo __('Revenir à la page d\'accueil', TEXT_DOMAIN); ?></a>
                    <a href="<?php echo get_permalink(BLOG_PAGE_ID); ?>"
                       class="btn btn-secondary"><?php echo __('Voir notre actualité', TEXT_DOMAIN); ?></a>
                </div>
            </div>
        </div>
    </div>

<?php get_footer();