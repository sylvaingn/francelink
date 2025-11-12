<?php
/**
 * reinsurances block
 *
 * @package      ContentifyTheme
 * @subpackage   blocks/reinsurances
 * @author       Sylvain Gounon
 * @since        1.0.0
 **/

/** @var array $block */
$block_obj = new \ContentifyTheme\Blocks\SingleBlock($block);

$fields = $block_obj->get_block_fields();
$description = $fields['reinsurances--description'] ?? '';
$button = $fields['reinsurances--button'] ?? [];
$items = $fields['reinsurances-items'] ?? [];
$source = $fields['reinsurances-source'] ?? '';
$align = $fields['reinsurances--align'] ?? 'center';
$background_id = $fields['reinsurances-background'] ?? false;

if (empty($items)) return;
?>

<div <?php echo $block_obj->body_block(sprintf('reinsurances-block large-content %s', $background_id ? '' : 'no-background')); ?>>

    <?php if ($background_id): ?>
        <div class="reinsurances--background">
            <?php echo wp_get_attachment_image($background_id, 'large'); ?>
        </div>
    <?php endif; ?>

    <?php echo $block_obj->get_illustrations(); ?>

    <div class="container container-small">
        <?php echo $block_obj->get_block_title('section-title'); ?>

        <?php if (!empty($description)): ?>
            <div class="reinsurances--description"><?php echo $description; ?></div>
        <?php endif; ?>
    </div>
    <div class="container container-large">
        <div class="reinsurances--items swiper">
            <div class="swiper-wrapper">
                <?php foreach ($items as $item):
                    $item_icon_id = $item['item-icon'] ?? '';
                    $item_number = $item['item-number'] ?? '';
                    $item_title = $item['item-title'] ?? '';
                    $item_text = $item['item-text'] ?? '';
                    ?>
                    <div class="swiper-slide reinsurance--item <?php echo $align; ?>">
                        <?php if ($item_icon_id && $item_icon_id !== ''): ?>
                            <div class="item-icon"
                                 style="--icon-url:url(<?php echo wp_get_attachment_image_url($item_icon_id) ?>);">
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($item_number)): ?>
                            <div class="frame-title title"><?php echo $item_number; ?></div>
                        <?php endif; ?>

                        <?php if ($item_title && $item_title !== ''): ?>
                            <div class="sub-title title"><?php echo $item_title; ?></div>
                        <?php endif; ?>

                        <?php if ($item_text && $item_text !== ''): ?>
                            <div class="item-text"><?php echo $item_text; ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <?php if (!empty($source)): ?>
            <div class="reinsurances--source"><?php echo $source; ?></div>
        <?php endif; ?>

        <?php if (!empty($button)):
            $button_link = $button['url'] ?? '';
            $button_target = $button['target'] ?? '';
            $button_title = $button['title'] ?? '';
            ?>
            <a href="<?php echo $button_link; ?>"
               target="<?php echo $button_target; ?>"
               class="btn <?php echo $background_id ? 'btn-secondary' : 'btn'; ?>"><?php echo $button_title; ?></a>
        <?php endif; ?>
    </div>
</div>