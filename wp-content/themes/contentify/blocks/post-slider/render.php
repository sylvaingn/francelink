<?php
/**
 * post-slider block
 *
 * @package      ContentifyTheme
 * @subpackage   blocks/post-slider
 * @author       …
 * @since        1.0.0
 */

$block_obj = new \ContentifyTheme\Blocks\SingleBlock($block);
$fields = $block_obj->get_block_fields();

$display_full = $fields['posts_slider-display_full'] ?? false;
$latest_posts = $fields['posts_slider-latest_posts'] ?? false;
$slider_items = $fields['posts_slider-items'] ?? [];
$slider_post_type = $fields['posts_slider-post_type'] ?? false;
$items_template = $fields['posts_slider-items_template'] ?? 'full_card';
$is_related = $fields['posts_slider-related'] ?? false;

if ($latest_posts && $slider_post_type) {
    $args = [
        'post_type' => $slider_post_type,
        'posts_per_page' => 10,
        'fields' => 'ids',
    ];

    if ($is_related) {
        $args['meta_query'] = [
            'relation' => 'OR',
            [
                'key' => 'attached-gab',
                'value' => get_the_ID(),
                'compare' => 'LIKE',
            ],
        ];
    }

    $slider_items = get_posts($args);
}

if (empty($slider_items)) {
    return;
}

$button_labels = [
    'post' => [
        'label' => __('Toutes les actualités', TEXT_DOMAIN),
        'url' => get_permalink(get_option('page_for_posts')),
    ],
    'tribe_events' => [
        'label' => __('Toutes nos formations et événements', TEXT_DOMAIN),
        'url' => get_post_type_archive_link('tribe_events'),
    ],
];
?>

<div <?php echo $block_obj->body_block(sprintf('posts-slider-block large-content %s', $display_full ? 'full' : '')); ?>>
    <?php echo $block_obj->get_illustrations(); ?>

    <div class="container <?php echo $display_full ? 'container-full' : 'container-large'; ?>">

        <?php echo $display_full ? '' : $block_obj->get_block_title('section-title lower-line'); ?>

        <div class="posts-slider--slider <?php echo esc_attr($items_template); ?>">
            <div class="swiper swiper-posts">
                <div class="swiper-wrapper">
                    <?php
                    set_query_var('display_full', $display_full);

                    $is_event = ('tribe_events' === $slider_post_type);

                    foreach ($slider_items as $item) :
                        $template_args = is_array($item) ? $item : ['post_id' => $item];

                        if ($is_event) {
                            $slug = 'template-parts/loop/card-event';
                            $name = null;
                        } else {
                            $slug = 'template-parts/loop/slider-card-post';
                            $name = $items_template;
                        }

                        get_template_part($slug, $name, $template_args);
                    endforeach;
                    ?>
                </div>
            </div>
            <div class="posts-slider-pagination--container">
                <div class="posts-slider-pagination">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>

        <?php if (array_key_exists($slider_post_type, $button_labels)) : ?>
            <a href="<?php echo esc_url($button_labels[$slider_post_type]['url']); ?>"
               class="btn">
                <?php echo esc_html($button_labels[$slider_post_type]['label']); ?>
            </a>
        <?php endif; ?>
    </div>
</div>
