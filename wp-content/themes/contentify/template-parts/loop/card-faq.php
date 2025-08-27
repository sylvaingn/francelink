<?php
$post_id = get_the_ID(); // ok en boucle principale
$terms_slugs = [];

$terms = get_the_terms( $post_id, 'type-faq' );

if ( $terms && ! is_wp_error($terms) ) {
    // Plus simple et sûr : extrait directement les slugs
    $terms_slugs = wp_list_pluck( $terms, 'slug' );
}
?>
<div class="faq-card stretched-container"
     data-post-terms="<?php echo esc_attr( implode(',', $terms_slugs) ); ?>">
    <div class="faq-card--content">
        <a href="<?php the_permalink(); ?>" class="title stretched-link"><?php the_title(); ?></a>
    </div>
</div>
