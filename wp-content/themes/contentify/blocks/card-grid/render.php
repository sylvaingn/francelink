<?php
/**
 * card-grid block
 *
 * @package      ContentifyTheme
 * @subpackage   blocks/card-grid
 * @author       Sylvain Gounon
 * @since        1.0.0
 **/

/** @var array $block */
$block_obj = new \ContentifyTheme\Blocks\SingleBlock($block);

$fields = $block_obj->get_block_fields();
$description = $fields['card_grid-description'] ?? '';
$columns_nb = $fields['card_grid-columns_nb'] ?? 1;
$layout_details = $fields['card_grid-elements'][0] ?? []; // Un seul élément autorisé
$additional_infos = $fields['card_grid-infos'] ?? [];
$switch_title = $fields['card_grid-switch_title'] ?? false;
?>

<div <?php echo $block_obj->body_block('card-grid-block'); ?>>
    <?php echo $block_obj->get_illustrations(); ?>
    <?php if (!$switch_title): ?>
        <div class="container container-small">
            <?php echo $block_obj->get_block_title('section-title lower-line'); ?>
            <?php if ($description !== ''): ?>
                <div class="description">
                    <?php echo $description; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="container container-large">
        <div class="card-grid--wrapper <?php echo $switch_title ? 'switched-title' : ''; ?>">
            <?php if ($switch_title): ?>
                <div class="title--wrapper">
                    <?php echo $block_obj->get_block_title('sub-title'); ?>
                    <?php if ($description !== ''): ?>
                        <div class="description--switched">
                            <?php echo $description; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($layout_details)): ?>
                <?php
                $layout_name = $layout_details['acf_fc_layout'] ?? '';
                $layout_elements = $layout_details[$layout_name] ?? [];
                ?>
                <div class="card-list--wrapper <?php echo 'layout-' . $layout_name; ?>"
                     style="--nb-column: <?php echo $columns_nb; ?>">
                    <?php foreach ($layout_elements as $element) {
                        get_template_part('template-parts/loop/flex', $layout_name, ['element' => $element]);
                    } ?>
                </div>
            <?php endif; ?>

            <?php
            $title = $additional_infos['infos-title'] ?? '';
            $content = $additional_infos['infos-content'] ?? '';
            $buttons = $additional_infos['infos-buttons'] ?? [];
            if (!empty($title) || !empty($content) || !empty($button)):?>
                <div class="additional-infos">
                    <?php if (!empty($title)): ?>
                        <div class="infos--title"><?php echo $title; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($content)): ?>
                        <div class="infos--content"><?php echo $content; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($buttons)): ?>
                        <div class="infos--buttons">
                            <?php foreach ($buttons as $button):
                                $button = $button['infos-button'];
                                $button_url = $button['url'] ?? '';
                                $button_target = $button['target'] ?? '';
                                $button_title = $button['title'] ?? '';
                                ?>
                                <a href="<?php echo $button_url; ?>" class="btn btn-secondary"
                                   target="<?php echo $button_target; ?>"><?php echo $button_title; ?></a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>