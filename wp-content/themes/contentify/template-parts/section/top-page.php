<?php
$page_id = is_home() ? get_option('page_for_posts') : get_the_ID();
$title = (is_archive()) ? get_the_archive_title() : get_the_title($page_id);

$query_area_after_id = get_query_var('query_area_after_id') ?? null;

if (isset($query_area_after_id)) {
    $thumbnail = get_the_post_thumbnail($query_area_after_id, 'large');

} else {
    $thumbnail = (!is_archive()) ? get_the_post_thumbnail($page_id, 'large') : '';
}

$excerpt = ((is_category() || is_archive()) ? category_description() : has_excerpt()) ? get_the_excerpt($page_id) : '';

$gab_logo_id = get_field('gab-logo', get_the_ID());
?>

<div class="top-page large-content">
    <div class="top-page--thumbnail">
        <?php echo $thumbnail; ?>
    </div>
    <div class="container">
        <div class="top-page--content">
            <?php if ($gab_logo_id && $gab_logo_id !== ''): ?>
                <div class="gab-logo">
                    <?php echo wp_get_attachment_image($gab_logo_id, 'large') ?>
                </div>
            <?php endif; ?>
            <h1 class="big-title"><?php echo $title; ?></h1>
        </div>
    </div>
</div>