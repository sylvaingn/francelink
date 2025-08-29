<?php get_header(); ?>

<?php get_template_part('template-parts/section/top-page'); ?>
    <div class="container container-large">
        <?php echo get_breadcrumb(); ?>
    </div>

    <div id="page-content">
        <div class="container container-large">
            <?php the_content(); ?>
        </div>
    </div>

<?php get_footer();