<?php
$element = $args['element'] ?? [];

if (empty($element)) return;

$element_icon_id = $element['text_icon_card-icon'] ?? '';
$element_title = $element['text_icon_card-title'] ?? '';
$element_content = $element['text_icon_card-content'] ?? '';
$element_button = $element['text_icon_card-button'] ?? [];
?>


<div class="text-icon-card">
    <div class="text-icon-card--icon card-icon">
        <?php echo wp_get_attachment_image($element_icon_id, 'large') ?>
    </div>
    <div class="text-icon-card--title"><?php echo $element_title; ?></div>

    <?php if ($element_content !== ''): ?>
        <div class="text-icon-card--content card-content"><?php echo $element_content; ?></div>
    <?php endif; ?>

    <?php if (!empty($element_button)): ?>
        <a href="<?php echo $element_button['url']; ?>" class="btn btn-secondary"
           target="<?php echo $element_button['target']; ?>"><?php echo $element_button['title']; ?></a>
    <?php endif; ?>
</div>
