<?php
$terms = get_the_terms(get_the_ID(), 'type-faq');

$terms_slugs = array_map(function ($term) {
    return $term->slug;
}, $terms);

?>
<div class="faq-card stretched-container" data-post-terms="<?php echo implode(',', $terms_slugs); ?>">
    <div class="faq-card--content">
        <a href="<?php the_permalink(); ?>" class="title stretched-link"><?php the_title(); ?></a>
    </div>
</div>