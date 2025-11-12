<?php
/**
 * quote block
 *
 * @package      ContentifyTheme
 * @subpackage   blocks/quote
 * @author       Sylvain Gounon
 * @since        1.0.0
 **/

/** @var array $block */
$block_obj = new \ContentifyTheme\Blocks\SingleBlock($block);

$fields = $block_obj->get_block_fields();
$quotes = $fields['quote_items'] ?? [];
?>

<section <?php echo $block_obj->body_block('block--quote large-content'); ?>>
    <div class="container container-large">
        <?php echo $block_obj->get_block_title('section-title'); ?>
        <?php if (!empty($quotes)) : ?>
            <div class="swiper">
                <div class="swiper-wrapper wrapper--quote-cards">
                    <?php foreach ($quotes as $k => $item) : ?>
                        <?php set_query_var('item', $item); ?>
                        <?php get_template_part('template-parts/loop/card-quote'); ?>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>

        <?php endif; ?>
    </div>
</section>