<?php
/**
 * dropdown-menu block
 *
 * @package      ContentifyTheme
 * @subpackage   blocks/dropdown-menu
 * @author       Sylvain Gounon
 * @since        1.0.0
 **/

/** @var array $block */
$block_obj = new \ContentifyTheme\Blocks\SingleBlock($block);

$fields = $block_obj->get_block_fields();
?>

<section <?php echo $block_obj->body_block('block--dropdown-menu'); ?>>
    <div class="container container-large">
        <?php echo $block_obj->get_block_title("section-title"); ?>
        <div class="wrapper--items">
            <?php
            get_template_part('template-parts/loop/dropdown-menu-item');
            ?>
        </div>
    </div>
</section>