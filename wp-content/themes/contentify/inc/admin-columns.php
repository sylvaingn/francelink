<?php

/**
 * Colonne pour les block areas
 */
add_filter('manage_archive-template_posts_columns', function ($columns) {
    $post_type_column = ['assigned-post_type' => __('Type de post', TEXT_DOMAIN)];
    $area_column = ['assigned-area' => __('Position', TEXT_DOMAIN)];


    $offset = array_search('date', array_keys($columns));
    return array_merge(array_slice($columns, 0, $offset), $post_type_column, $area_column, array_slice($columns, $offset, null));
}, 10, 1);

add_action('manage_archive-template_posts_custom_column', function ($column_key, $post_id) {
    $post_type = [
        'archive-post' => __('Page des actualités', TEXT_DOMAIN),
        'post' => __('Articles', TEXT_DOMAIN)
    ];

    $position = [
        'before' => __('Avant le contenu', TEXT_DOMAIN),
        'after' => __('Après le contenu', TEXT_DOMAIN),
    ];

    if ($column_key == 'assigned-post_type') {
        $assigned_post_type = get_field('assigned-post_type', $post_id);

        if (!empty($assigned_post_type)) {
            echo $post_type[$assigned_post_type];
        } else {
            echo __('Pas d\'affiliation', TEXT_DOMAIN);
        }
    }

    if ($column_key == 'assigned-area') {
        $assigned_area = get_field('assigned-area', $post_id);

        if (!empty($assigned_area)) {
            echo $position[$assigned_area];
        } else {
            echo __('Pas d\'affiliation', TEXT_DOMAIN);
        }
    }
}, 10, 2);

/**
 * Colonne pour les évènements
 */
add_filter('manage_evenement_posts_columns', 'ajouter_colonne_date_evenement');
function ajouter_colonne_date_evenement($columns)
{
    $new_columns = array();
    foreach ($columns as $key => $title) {
        $new_columns[$key] = $title;
        if ('title' === $key) {
            $new_columns['evenement-date'] = __('Date de l’événement', 'textdomain');
        }
    }
    return $new_columns;
}

add_action('manage_evenement_posts_custom_column', 'remplir_colonne_date_evenement', 10, 2);
function remplir_colonne_date_evenement($column, $post_id)
{
    if ('evenement-date' === $column) {
        $date = get_field('evenement-date', $post_id, false);
        if (!empty($date)) {
            $date_ts = strtotime($date);
            echo date_i18n('d/m/Y - H:i:s', $date_ts);
        }
    }
}

add_filter('manage_edit-evenement_sortable_columns', 'rendre_colonne_date_evenement_sortable');
function rendre_colonne_date_evenement_sortable($columns)
{
    $columns['evenement-date'] = 'evenement-date';
    return $columns;
}

add_action('pre_get_posts', 'ordre_tri_colonne_date_evenement');
function ordre_tri_colonne_date_evenement($query)
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    if ('evenement-date' === $query->get('orderby')) {
        $query->set('meta_key', 'evenement-date');
        $query->set('orderby', 'meta_value');
        $query->set('meta_type', 'DATETIME');
    }
}
