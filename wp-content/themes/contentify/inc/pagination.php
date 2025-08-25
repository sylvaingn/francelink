<?php

function the_custom_pagination($args = [], $class = 'pagination'): void
{
    // On ne se fie plus au global, on regarde "total" passé en paramètre
    $total = !empty($args['total']) ? (int)$args['total'] : 0;
    if ($total <= 1) {
        return; // s'il n'y a qu'une page ou pas de valeur, on sort
    }

    // Valeur par défaut si manquantes
    // (on force 'total' ici pour éviter que wp_parse_args ne l'écrase)

    $defaults = [
        'total' => $total,
//        'base' => str_replace(999999999, '%#%', get_pagenum_link(999999999, false)),
        'format' => '?paged=%#%', // ou '&paged=%#%'
        'mid_size' => 999,
        'prev_next' => false,
        'prev_text' => '<i class="icon-arrow prev"></i>',
        'next_text' => '<i class="icon-arrow"></i>',
        'screen_reader_text' => __('Pages', TEXT_DOMAIN),
    ];
    


    $args = wp_parse_args($args, $defaults);


    $links = paginate_links($args);
    if (empty($links)) {
        return;
    }

    // Template
    $template = apply_filters('custom_navigation_markup_template', '
        <nav class="ajax-pagination navigation %1$s" role="navigation">
            <span class="screen-reader-text">%2$s</span>
            <div class="nav-links"><div class="page-numbers-container">%3$s</div></div>
        </nav>', $args, $class);

    echo sprintf($template, $class, $args['screen_reader_text'], $links);
}
