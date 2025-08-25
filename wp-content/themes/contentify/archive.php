<?php get_header(); ?>

    <h1><?php the_archive_title(); ?></h1>

<?php if (have_posts()): ?>
    <div class="archive-posts--wrapper">
        <?php while (have_posts()) {
            the_post();
//            get_template_part('template-parts/archive/archive-post');
        } ?>
    </div>
<?php endif; ?>

<?php get_footer();