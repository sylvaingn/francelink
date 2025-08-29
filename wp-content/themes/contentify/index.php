<?php
get_header();

$query_area_before = ContentifyTheme\Blocks\Blocks::get_instance()->get_block_area(get_post_type(), 'before');
$query_area_after = ContentifyTheme\Blocks\Blocks::get_instance()->get_block_area(get_post_type(), 'after');
?>

<?php get_template_part('template-parts/section/top-page'); ?>

    <div class="container container-large">
        <?php echo get_breadcrumb(); ?>
    </div>

<?php if ($query_area_before !== null) : ?>
    <?= apply_filters('the_content', $query_area_before->post_content); ?>
<?php endif; ?>

    <div id="page-content">
        <div class="container container-large">
            <?php the_content(); ?>
        </div>
    </div>

<?php if ($query_area_after !== null) : ?>
    <?= apply_filters('the_content', $query_area_after->post_content); ?>
<?php endif; ?>

<?php
get_footer();
