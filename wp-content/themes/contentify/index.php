<?php
get_header();

$query_area_before = ContentifyTheme\Blocks\Blocks::get_instance()->get_block_area( get_post_type(), 'before' );
$query_area_after = ContentifyTheme\Blocks\Blocks::get_instance()->get_block_area( get_post_type(), 'after' );
?>


<?php if ( $query_area_before !== null ) : ?>
	<?= apply_filters( 'the_content', $query_area_before->post_content ); ?>
<?php endif; ?>

<?php the_content(); ?>

<?php if ( $query_area_after !== null ) : ?>
	<?= apply_filters( 'the_content', $query_area_after->post_content ); ?>
<?php endif; ?>

<?php
get_footer();
