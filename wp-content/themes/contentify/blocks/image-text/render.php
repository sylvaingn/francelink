<?php
/**
 * image-text block
 *
 * @package      ContentifyTheme
 * @subpackage   blocks/image-text
 * @author       Sylvain Gounon
 * @since        1.0.0
 **/

/** @var array $block */
$block_obj = new \ContentifyTheme\Blocks\SingleBlock($block);

$fields = $block_obj->get_block_fields();
$image_id = $fields['image_text-image'] ?? '';
$content = $fields['image_text-content'] ?? '';

$additional_text = $fields['image_text-additional_text'] ?? '';
$additional_buttons = $fields['image_text-additional_buttons'] ?? [];

$align_variant = $fields['image_text-align_variant'] ?? '';
$group_title = $fields['image_text-group_title'] ?? false;
$reversed_color = $fields['image_text-reversed_color'] ?? false;
$framing_content = $fields['image_text-framing_content'] ?? 'none';

$img_additionnal_style = "";
$img_additionnal_classes = "";

$image_options = $fields['image_options'] ?? false;

if ($image_options) {
    $image_options_contains = $fields['image_options-contains'] ?? false;
    $image_options_border_radius = $fields['image_options-border_radius'] ?? true;

    $img_additionnal_style .= $image_options_contains ? 'object-fit:contain;' : '';
    $img_additionnal_classes .= !$image_options_border_radius ? 'no-radius' : '';

    if ($image_options_contains) {
        $image_options_height = $fields['image_options-height'] ?? '';
        $img_additionnal_style .= !empty($image_options_height) ? 'height:' . $image_options_height . 'px;' : '';
    } else {
        $image_options_position = $fields['image_options-position'] ?? 'center-center';
        $image_options_position = str_replace('-', ' ', $image_options_position);
        $img_additionnal_style .= "object-position:$image_options_position;";
    }
}
?>

<div <?php echo $block_obj->body_block(sprintf('image-text-block large-content %s %s', $align_variant, $reversed_color ? 'reversed-color' : '')); ?>>
    <?php echo $block_obj->get_illustrations(); ?>
    <div class="container container-large">
        <?php echo !$group_title ? $block_obj->get_block_title('section-title lower-line') : ''; ?>
        <div class="image-text--wrapper <?php echo 'framing-content--' . $framing_content; ?>">
            <div class="wrapper--top">
                <?php if (!empty($content)): ?>
                    <div class="image-text--content">
                        <?php echo $group_title ? $block_obj->get_block_title('section-title lower-line text-left') : ''; ?>

                        <?php if ($content && $content !== ''): ?>
                            <div class="content--text">
                                <?php echo $content; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($additional_buttons)): ?>
                            <div class="wrapper--bottom">
                                <?php foreach ($additional_buttons as $k => $additional_button):
                                    $btn_link_object = $additional_button['button-item'];
                                    $btn_url = $btn_link_object['url'] ?? '';
                                    $btn_target = $btn_link_object['target'] ?? '';
                                    $btn_title = $btn_link_object['title'] ?? '';
                                    ?>
                                    <a href="<?php echo $btn_url; ?>"
                                       class="btn <?php echo $reversed_color ? 'btn-secondary' : ''; ?> <?php echo ($k % 2 == 1) ? 'btn-secondary' : ''; ?>"
                                       target="<?php echo $btn_target; ?>">
                                        <?php echo $btn_title; ?>
<!--                                        --><?php //if (isPdfLink($btn_url)): ?>
<!--                                            <i class="icon-pdf"></i>-->
<!--                                        --><?php //endif; ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if ($image_id && $image_id !== ''): ?>
                    <div class="image-text--thumbnail <?php echo empty($content) ? 'full' : ''; ?> ">
                        <div class="thumbnail--image">
                            <?php echo wp_get_attachment_image($image_id, 'large', attr: [
                                'style' => $img_additionnal_style,
                                'class' => $img_additionnal_classes
                            ]); ?>
                        </div>
                        <?php
                        $caption = wp_get_attachment_caption($image_id);

                        if (!empty($caption)):?>
                            <div class="thumbnail--caption">
                                <?php echo $caption; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
