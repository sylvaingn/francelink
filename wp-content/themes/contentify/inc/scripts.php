<?php

define('THEME_VERSION', time());
define('DIST_URL', get_template_directory_uri() . '/dist/');

function contentify_scripts()
{
    wp_enqueue_style('contentify-style', DIST_URL . 'styles.css', array(), THEME_VERSION);

    wp_enqueue_script('contentify-gsap-js', DIST_URL . 'gsap-setup.js', array(), THEME_VERSION, true);
    wp_enqueue_script('contentify-swiper-js', DIST_URL . 'swiper-setup.js', array(), THEME_VERSION, true);
    wp_enqueue_style('contentify-swiper-css', DIST_URL . 'swiper-setup.css', array(), THEME_VERSION);

    $scripts_deps = ['contentify-gsap-js', 'contentify-swiper-js'];

    wp_enqueue_script('contentify-js', DIST_URL . 'scripts.js', $scripts_deps, THEME_VERSION, true);
    wp_add_inline_script('contentify-js', 'const site_uri = "' . get_site_url() . '"; const stylesheet_directory_uri = "' . get_stylesheet_directory_uri() . '";');

    if (is_search()) {
        wp_enqueue_style('contentify-search-style', DIST_URL . 'pages/search.css', array(), THEME_VERSION);
    }

    if (is_404()) {
        wp_enqueue_style('contentify-404-style', DIST_URL . 'pages/404.css', array(), THEME_VERSION);
    }

    if (is_archive()) {
        $ajax_nonce = wp_create_nonce('my_ajax_nonce');

        wp_enqueue_style('contentify-archive-style', DIST_URL . 'archives/archive.css', array(), THEME_VERSION);
        wp_enqueue_script('contentify-archive-js', DIST_URL . 'archives/archive-js.js', $scripts_deps, THEME_VERSION, true);

        wp_localize_script(
            'contentify-archive-js',
            'myAjaxVars', // Nom de l'objet JS
            [
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'ajaxNonce' => $ajax_nonce,
                'currentPostType' => get_post_type()
            ]
        );
    }
}

function contentify_footer_styles()
{
    wp_enqueue_style('contentify-footer-style', DIST_URL . 'footer.css', array(), THEME_VERSION);
    wp_enqueue_script('contentify-footer-js', DIST_URL . '/footer.js', [], '1.1', true);
}

function contentify_ajouter_styles_editeur()
{
    add_editor_style(DIST_URL . 'global-editor.css');
    add_editor_style(DIST_URL . 'swiper-setup.css');
}

add_action('init', 'contentify_ajouter_styles_editeur');
add_action('wp_enqueue_scripts', 'contentify_scripts');
add_action('wp_footer', 'contentify_footer_styles');

function admin_css()
{
    wp_enqueue_style('contentify-admin', DIST_URL . 'admin-styles.css');
}

add_action('admin_print_styles', 'admin_css', 11);