<?php
$element = $args['element'] ?? [];

if (empty($element)) return;

$element_image_id = $element['text_image_card-image'] ?? '';
$element_title = $element['text_image_card-title'] ?? '';

if (empty($element_title)) return;

$element_content = $element['text_image_card-content'] ?? '';
?>


<div class="text-image-card">
    <div class="text-image-card--image card-image">
        <?php echo wp_get_attachment_image($element_image_id, 'large') ?>
    </div>
    <div class="text-image-card--title card-title"><?php echo $element_title; ?></div>

    <?php if ($element_content !== ''): ?>
        <div class="text-image-card--content card-content"><?php echo $element_content; ?></div>
    <?php endif; ?>
</div>
