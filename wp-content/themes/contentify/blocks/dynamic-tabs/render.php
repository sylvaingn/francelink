<?php
/**
 * dynamic-tabs block
 *
 * @package      ContentifyTheme
 * @subpackage   blocks/dynamic-tabs
 * @author       Sylvain Gounon
 * @since        1.0.0
 **/

/** @var array $block */
$block_obj = new \ContentifyTheme\Blocks\SingleBlock($block);

$fields = $block_obj->get_block_fields();

$dynamic_tabs = $fields['dynamic_tabs-items'] ?? [];

if (empty($dynamic_tabs)) return;

$dynamic_tabs_titles = [];
$dynamic_tabs_contents = [];

foreach ($dynamic_tabs as $key => $tab) {
    $title = $tab['item-title'] ?? '';
    $text = $tab['item-text'] ?? '';
    $img_id = $tab['item-img'] ?? '';
    $img_contains = $tab['item-img_contains'] ?? false;

    if (!empty($title)) {
        $dynamic_tabs_titles[] = $title;
    } else {
        continue;
    }

    if (!empty($text)) {
        $dynamic_tabs_contents[$key]['text'] = $text;
    }
    if (!empty($img_id)) {
        $dynamic_tabs_contents[$key]['img'] = $img_id;
        $dynamic_tabs_contents[$key]['img_contains'] = $img_contains;
    }
}

?>

<div <?php echo $block_obj->body_block('dynamic-tabs-block'); ?>>
    <div class="container container-large">
        <?php echo $block_obj->get_block_title('section-title'); ?>
        <div class="missions-tabs--titles">
            <div class="titles--wrapper">
                <?php foreach ($dynamic_tabs_titles as $k => $title):
                    $isFirstEl = $k === 0; ?>
                    <div class="title card-title <?php echo $isFirstEl ? 'active' : ''; ?>"
                         data-index="<?php echo $k; ?>"><?php echo $title; ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="missions-tabs--content">
            <?php foreach ($dynamic_tabs_contents as $k => $content):
                $content_img_id = $content['img'] ?? '';
                $content_img_contains = $content['img_contains'] ?? false;
                $content_text = $content['text'] ?? '';

                $isFirstEl = $k === 0;
                ?>
                <div class="dynamic-tab--item <?php echo $isFirstEl ? 'active' : ''; ?>" data-index="<?php echo $k; ?>">
                    <div class="missions-text-img-img <?php echo $content_img_contains === true ? 'contains' : ''; ?>">
                        <?php echo wp_get_attachment_image($content_img_id, 'large'); ?>
                    </div>
                    <div class="missions-text-img-text">
                        <?php echo $content_text; ?>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
</div>