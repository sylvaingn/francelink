<?php
/**
 * !!name!! block
 *
 * @package      ContentifyTheme
 * @subpackage   blocks/!!name!!
 * @author       Sylvain Gounon
 * @since        1.0.0
 **/

/** @var array $block */
$block_obj = new \ContentifyTheme\Blocks\SingleBlock($block);

$fields = $block_obj->get_block_fields();
?>

<div <?php echo $block_obj->body_block(''); ?>>
    <div class="container container-large"></div>
</div>