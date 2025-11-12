<?php
$element = $args['element'] ?? [];

if (empty($element)) return;

$element_title = $element['checklist_card-title'] ?? '';
if (empty($element_title)) return;

$element_content = $element['checklist_card-content'] ?? '';
?>


<div class="checklist-card">
    <div class="checklist-card--title card-title"><?php echo $element_title; ?></div>

    <?php if ($element_content !== ''): ?>
        <div class="checklist-card--content card-content"><?php echo $element_content; ?></div>
    <?php endif; ?>
</div>
