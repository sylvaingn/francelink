<?php

add_action('admin_bar_menu', 'my_new_toolbar_item', 999);

function my_new_toolbar_item($wp_admin_bar)
{
    if (is_home() || is_archive()) {
        $area = 'archive-' . get_post_type();
    } else {
        $area = get_post_type();
    }

    $query_area_before = ContentifyTheme\Blocks\Blocks::get_instance()->get_block_area($area, 'before');
    $query_area_after = ContentifyTheme\Blocks\Blocks::get_instance()->get_block_area($area, 'after');

    if ($query_area_before !== null || $query_area_after !== null) {
        $menu = array(
            array(
                'id' => 'used_block_areas',
                'title' => 'Modèles utilisés',
                'href' => '',
            )
        );

        if ($query_area_before !== null) {
            $menu[] = [
                'id' => 'block_area_before',
                'title' => 'Modifier: ' . $query_area_before->post_title,
                'href' => get_edit_post_link($query_area_before->ID),
                'parent' => 'used_block_areas'
            ];
        }

        if ($query_area_after !== null) {
            $menu[] = [
                'id' => 'block_area_after',
                'title' => 'Modifier: ' . $query_area_after->post_title,
                'href' => get_edit_post_link($query_area_after->ID),
                'parent' => 'used_block_areas'
            ];
        }

        foreach ($menu as $args) {
            $wp_admin_bar->add_node($args);
        }
    }

}