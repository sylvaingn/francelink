<?php

require_once __DIR__ . '/blocks.php';

use ContentifyTheme\Blocks\Blocks;

$blocks = Blocks::get_instance();
add_action('init', [$blocks, 'init']);

function getCustomLogoUrl()
{
    $logo = get_theme_mod('custom_logo');
    $image = wp_get_attachment_image_src($logo, 'full');
    return $image[0] ?? "";
}


function get_breadcrumb(): string
{
    if (function_exists('yoast_breadcrumb')) {
        return yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
    } else {
        return '';
    }
}

/**
 * @param $content
 * @return mixed|string
 * @description On propose une possibilité de couper le texte après une balise "Lire la suite" dispo dans le WYSIWYG
 */
function more_text($content)
{
    $delimiters = '/(<span id="more-\d+"><\/span>|<!--more-->)/';
    $split_content = preg_split($delimiters, $content);

    if (count($split_content) > 1) {
        $content = $split_content[0] . '<div class="more-text">' . $split_content[1] . '</div>';
        $content .= '<span data-plus="' . __('Lire plus', TEXT_DOMAIN) . '" data-moins="' . __('Lire moins', TEXT_DOMAIN) . '">' . __('Lire plus', TEXT_DOMAIN) . '</span>';
    }

    return $content;
}

add_filter('the_content', 'more_text');

function contentify_setup()
{
    if (!defined('DISALLOW_FILE_EDIT')) define('DISALLOW_FILE_EDIT', true);
    if (!defined('DISALLOW_UPDATE_CORE')) define('DISALLOW_UPDATE_CORE', true);

    load_theme_textdomain(TEXT_DOMAIN, get_template_directory() . '/languages');

    add_theme_support('post-thumbnails');
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_theme_support('custom-units');
    add_theme_support('custom-logo');

    register_nav_menus(
        array(
            'menu-top' => __('Menu top', TEXT_DOMAIN),
            'menu-primary' => __('Menu primary', TEXT_DOMAIN),
            'menu-footer' => __('Menu footer', TEXT_DOMAIN),
            'menu-footer-1' => __('Menu footer 1', TEXT_DOMAIN),
            'menu-footer-2' => __('Menu footer 2', TEXT_DOMAIN),
            'menu-mentions' => __('Menu mentions', TEXT_DOMAIN),
        )
    );

    add_post_type_support('page', 'excerpt');
}

add_action('after_setup_theme', 'contentify_setup');


/**
 * @param $attr
 * @param $attachment
 * @param $size
 * @return mixed
 * @description Retourne les attributs de l'image sous des attributs que l'on manipulera plus tard pour les performances
 */
function custom_attachment_image_attributes($attr, $attachment, $size)
{
    $img_classes = $attr['class'] ?? '';

    if (strpos($img_classes, 'custom-logo') === false && strpos($img_classes, 'lazy-img') !== false) {
        $attr['data-src'] = $attr['src'] ?? '';
        $attr['data-srcset'] = $attr['srcset'] ?? '';
        $attr['src'] = get_template_directory_uri() . '/assets/img/lazy-loading-img.png';
        $attr['srcset'] = '';
    }

    return $attr;
}

add_filter('wp_get_attachment_image_attributes', 'custom_attachment_image_attributes', 10, 3);

add_filter('wp_get_attachment_image', function ($html, $attachment_id, $size, $icon, $attr) {
    $img_classes = $attr['class'] ?? '';

    if (strpos($img_classes, 'custom-logo') === false && strpos($img_classes, 'lazy-img') !== false) {
        $html .= '<span></span>';
    }

    return $html;
}, 10, 5);


/**
 * @param $template
 * @param $class
 * @return array|mixed|string|string[]
 * @description On change le h2 que la pagination de Wordpress nous impose
 */
function change_reader_heading($template, $class)
{
    if (!empty($class) && false !== strpos($class, 'pagination')) {
        $template = str_replace(['<h2', '</h2>'], ['<span', '</span>'], $template);
    }

    return $template;
}

add_filter('navigation_markup_template', 'change_reader_heading', 10, 2);

add_filter('get_the_archive_title', function ($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_tax()) { //for custom post types
        $title = sprintf(__('%1$s'), single_term_title('', false));
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    }
    return $title;
});