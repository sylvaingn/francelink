<?php
$dropdown_items = get_field("dropdown-add-item") ?? [];

if (is_array($dropdown_items)) :
    foreach ($dropdown_items as $item) :
        $dropdown_item_title = $item['dropdown-item-title'] ?? "";
        $dropdown_item_description = $item['dropdown-item-description'] ?? "";
        ?>

        <article class="dropdown-menu-item dashed-border">
            <div class="header--dropdown-menu-item">
                <h2 class="title subtitle"><?php echo $dropdown_item_title ?></h2>
                <i class="fa-regular fa-arrow-right"></i>            </div>
            <div class="content--dropdown-menu">
                <div><?php echo $dropdown_item_description; ?></div>
            </div>
        </article>

    <?php endforeach;
endif; ?>