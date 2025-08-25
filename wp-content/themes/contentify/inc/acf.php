<?php

if (function_exists('acf_add_options_page')) {
    add_action('acf/init', function () {
        acf_add_options_page(array(
            'page_title' => 'Options site',
            'menu_slug' => 'options-site',
            'position' => '',
            'redirect' => false,
        ));

        acf_add_options_page(array(
            'page_title' => 'Pages assignées',
            'menu_slug' => 'assigned-pages',
            'parent_slug' => 'options-site',
            'position' => '',
            'redirect' => false,
        ));
    });
} else {
    echo '<script language="javascript">alert ("Avant de continuer, installer ACF Pro." )</script>';

}

