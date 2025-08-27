<?php get_header(); ?>

    <div id="home-top-page" class="large-content">
        <div class="container container-small">
            <div class="home-top-page--wrapper">
                <h1><?php echo get_bloginfo('name'); ?></h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque debitis deleniti dignissimos dolores
                fugit hic mollitia nihil. Accusantium aliquam animi consectetur culpa cumque deleniti est fuga impedit,
                nostrum voluptate. Accusantium?</p>
                <a href="<?php echo get_post_type_archive_link('faq') ?>"
                   class="btn"><?php echo __('Une question ?', TEXT_DOMAIN); ?></a>
            </div>
        </div>
    </div>
<?php //the_content(); ?>

<?php get_footer();
