<?php

add_action('wp_ajax_my_ajax_fetch_actualities', 'my_ajax_fetch_actualities');
add_action('wp_ajax_nopriv_my_ajax_fetch_actualities', 'my_ajax_fetch_actualities');

/**
 * Récupère les posts filtrés via WP_Query et renvoie du HTML
 */
function my_ajax_fetch_actualities(): void
{
    $post_type = sanitize_text_field($_POST['post_type'] ?? $_GET['post_type'] ?? get_post_type());

    $search = sanitize_text_field($_POST['search'] ?? $_GET['search'] ?? '');
    $order = sanitize_text_field($_POST['order'] ?? $_GET['order'] ?? '');
    $cat = sanitize_text_field($_POST['cat'] ?? $_GET['cat'] ?? '');
    $paged = sanitize_text_field($_POST['paged'] ?? $_GET['paged'] ?? '');



    $related_taxonomy = match ($post_type) {
        'post' => 'category',
        'faq' => 'type-faq',
        default => 'category'
    };

    $args = [
        'post_type' => $post_type,
        'posts_per_page' => DEFAULT_POSTS_PER_PAGE,
        'paged' => $paged,
        'post_status' => 'publish'
    ];

    // Recherche
    if (!empty($search)) {
        $args['s'] = $search;
    }

    // Ordre
    if ($order === 'newer') {
        $args['order'] = 'DESC';
    } elseif ($order === 'older') {
        $args['order'] = 'ASC';
    }

    // Catégories multiples
    if (!empty($cat)) {
        $cat_slugs = explode(',', $cat);
        $cat_filters = array_map(function ($cat_slug) use ($related_taxonomy) {
            return [
                'taxonomy' => $related_taxonomy,
                'field' => 'slug',
                'terms' => $cat_slug,
            ];
        }, $cat_slugs);
        $args['tax_query'] = ['relation' => 'AND'];
        $args['tax_query'] = array_merge($args['tax_query'], $cat_filters);
    }

//    Cache les publications si elles n'ont pas de fichier lié

//    if ($post_type === 'publication-tech') {
//        $meta_query = $args['meta_query'] ?? [];
//        $tech_meta = [
//            'key' => 'tech-doc',
//            'value' => '',
//            'compare' => '!='
//        ];
//
//        $args['meta_query'][] = array_merge($meta_query, $tech_meta);
//    }

    // 4) On lance la requête
    $query = new WP_Query($args);

    $content = '';

    ob_start();

    // 5) Générer du HTML
    if ($query->have_posts()) : ?>
        <div class="posts--wrapper">
            <?php
            while ($query->have_posts()) {
                $query->the_post();
                // Inclure votre template de post (ou un mini HTML)
                get_template_part('template-parts/loop/card', $post_type);
            }
            ?>
        </div>

        <?php

        the_custom_pagination([
            'total' => $query->max_num_pages,
            'current' => $paged
        ]);

    else :?>
        <div class="no-results"><?php echo __('Aucun résultat', TEXT_DOMAIN); ?></div>
    <?php endif;
    wp_reset_postdata();

    $get_tpl_card_loop = ob_get_contents();
    ob_end_clean();
    $content .= $get_tpl_card_loop;

    echo $content;
    ob_end_flush();


    if (wp_doing_ajax()) {
        wp_die();
    }
}