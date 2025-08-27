<?php
get_header();
$query_area_before = ContentifyTheme\Blocks\Blocks::get_instance()->get_block_area('archive-faq', 'before');
$query_area_after = ContentifyTheme\Blocks\Blocks::get_instance()->get_block_area('archive-faq', 'after');

set_query_var('query_area_after_id', $query_area_after->ID);
?>

<?php get_template_part('template-parts/archive/archive-posts-filter'); ?>

<?php if ($query_area_after !== null): ?>
    <?= apply_filters('the_content', $query_area_after->post_content); ?>
<?php endif; ?>

<?php
get_footer();
