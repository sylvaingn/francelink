<?php get_header(); ?>

    <div class="search-page large-content">
        <div class="container container-xlarge">
            <h1><?php echo __(sprintf('Résultats de recherche pour : %s',
                    $_GET['s']
                ), TEXT_DOMAIN); ?>
            </h1>
            <?php if (have_posts()): ?>
                <div class="search--grid">
                    <?php while (have_posts()):
                        the_post(); ?>
                        <?php echo get_template_part('template-parts/loop/card-search'); ?>
                    <?php endwhile; ?>
                </div>
                <?php the_custom_pagination(); ?>
            <?php else: ?>
                <div><?php echo __('Aucun résultat ne correspond à votre recherche', TEXT_DOMAIN); ?></div>
            <?php endif; ?>
        </div>
    </div>

<?php get_footer();