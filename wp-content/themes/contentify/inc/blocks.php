<?php

namespace ContentifyTheme\Blocks;

use WP_Post;
use WP_Query;

defined('DIST_BLOCK') or define('DIST_BLOCK', '/dist/blocks/');

/**
 * Gère les informations relatives à un block individuel
 */
class SingleBlock
{
    public array $block;

    public function __construct(array $block)
    {
        $this->block = $block;
    }

    /**
     * Retourne la chaîne à intégrer dans la balise principale du block :
     * classes, style et attribut data si hooké
     */
    public function body_block(string $additionnal_classes = '', string $additionnal_style = ''): string
    {
        return sprintf(
            '%s %s %s',
            $this->block_class($additionnal_classes),
            $this->get_block_style($additionnal_style),
            $this->getHookData()
        );
    }

    /**
     * Vérifie si le block est "hooké"
     */
    public function isHooked(): bool
    {
        $fields = $this->get_block_fields();
        return !empty($fields['hooked_block']) && $fields['hooked_block'] === true;
    }

    /**
     * Retourne l'attribut data-hooked si le block est hooké
     */
    public function getHookData(): string
    {
        return $this->isHooked() ? 'data-hooked' : '';
    }

    /**
     * Récupère les champs du block via ACF en s’assurant de retourner un tableau
     */
    public function get_block_fields(): array
    {
        $fields = get_fields($this->block['id']);
        return is_array($fields) ? $fields : [];
    }

    /**
     * Retourne l’attribut class du block + classes additionnelles
     */
    public function block_class(string $additionnal_classes = ''): string
    {
        return sprintf(
            'class="contentify-block %s %s %s"',
            is_admin() ? 'is-editing' : '',
            $this->get_block_classes(),
            esc_attr($additionnal_classes)
        );
    }

    /**
     * Récupère la classe CSS du block si définie dans le tableau $this->block
     */
    public function get_block_classes(): string
    {
        return isset($this->block['className']) ? esc_attr($this->block['className']) : '';
    }

    /**
     * Construit la string de style en tenant compte du backgroundColor et du spacing
     */
    public function get_block_style(string $additional_style = ''): string
    {
        $style_data = '';

        // Gestion de la couleur de fond
        $background_color = $this->block['backgroundColor'] ?? '';
        if (!empty($background_color)) {
            // On suppose que backgroundColor contient le slug de la couleur
            $style_data .= sprintf('background-color:var(--wp--preset--color--%s);', esc_attr($background_color));
        }

        $text_color = $this->block['textColor'] ?? '';
        if (!empty($text_color)) {
            // On suppose que backgroundColor contient le slug de la couleur
            $style_data .= sprintf('color:var(--wp--preset--color--%s);', esc_attr($text_color));
        }

        $spacing_styles = $this->block['style']['spacing'] ?? [];
        // Gestion des espacements (padding/margin etc.)
        if (!empty($spacing_styles) && is_array($spacing_styles)) {
            foreach ($spacing_styles as $property => $values) {
                if (is_array($values)) {
                    foreach ($values as $key => $value) {
                        if (is_string($value) && strpos($value, 'var:') !== false) {
                            $var_value = str_replace('var:', '', $value);
                            // On reconstruit la variable CSS
                            $var_value = '--wp--' . str_replace('|', '--', $var_value);
                            $style_data .= sprintf('%s-%s:var(%s);', $property, $key, esc_attr($var_value));
                        } else {
                            $style_data .= sprintf('%s-%s:%s;', $property, $key, esc_attr($value));
                        }
                    }
                }
            }
        }

        // Fusion des styles
        $final_style = trim($style_data . ' ' . $additional_style);

        return $final_style !== '' ? sprintf('style="%s"', $final_style) : '';
    }

    /**
     * Construit et retourne le titre du block (ACF block_title) dans la balise souhaitée
     *
     * @param string $classes Classes additionnelles
     * @param array $data Attributs HTML additionnels
     * @param array $array Tableau de données éventuellement passé à la fonction
     * @return string         Le titre formaté ou une string vide
     */
    public function get_block_title(string $classes = '', array $data = [], array $array = []): string
    {
        $group = !empty($array) ? $array : $this->get_block_fields();
        $title = $group['block_title'] ?? '';
        $tag = $group['block_title-tag'] ?? 'div'; // Tag par défaut si non défini
        $subtitle = $group['block_sub_title'] ?? '';
        $subtitle_tag = $group['block_sub_title-tag'] ?? 'div'; // Tag par défaut si non défini

        if (!empty($title)) {
            $data_string = '';
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    $data_string .= sprintf(
                        ' %s="%s"',
                        esc_attr($key),
                        esc_attr($value)
                    );
                }
            }

            return sprintf(
                '<div class="block-title"><%1$s class="title %2$s"%4$s><span>%3$s</span></%1$s><%5$s class="title main-title">%6$s</%5$s></div>',
                esc_attr($tag),
                esc_attr($classes),
                // On autorise seulement quelques balises dans le titre (ex: <em>, <br>)
                strip_tags($title, '<em><br>'),
                $data_string,
                esc_attr($subtitle_tag),
                strip_tags($subtitle, '<em><br>')
            );
        }

        return '';
    }

    public function get_block_subtitle(string $classes = '', array $data = [], array $array = []): string
    {
        $group = !empty($array) ? $array : $this->get_block_fields();
        $title = $group['block_sub_title'] ?? '';
        $tag = $group['block_sub_title-tag'] ?? 'h3'; // Tag par défaut si non défini

        if (!empty($title)) {
            $data_string = '';
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    $data_string .= sprintf(
                        ' %s="%s"',
                        esc_attr($key),
                        esc_attr($value)
                    );
                }
            }

            return sprintf(
                '<%1$s class="block-title title %2$s"%4$s>%3$s</%1$s>',
                esc_attr($tag),
                esc_attr($classes),
                // On autorise seulement quelques balises dans le titre (ex: <em>, <br>)
                strip_tags($title, '<em><br>'),
                $data_string
            );
        }

        return '';
    }

    /**
     * Retourne les illustrations du block
     *
     * @return string
     */
    public function get_illustrations(): string
    {
        $group = !empty($array) ? $array : $this->get_block_fields();
        $illustrations = $group['background_illustrations'] ?? [];
        $content_string = '';
        if (!empty($illustrations)) {
            foreach ($illustrations as $illustration) {
                $illustration_class = $illustration['background_illustration-position'] ?? '';
                $data_animation = $illustration['background_illustration-switch'] === true ? "reverse" : "normal";
                $img_url = wp_get_attachment_image_url($illustration['background_illustration-image'], 'large');

                $content_string .= sprintf(
                    '<div class="background-illustration %s" data-animation="%s"><img src="%s" alt=""></div>',
                    $illustration_class,
                    $data_animation,
                    $img_url
                );
            }
        }

        return $content_string;
    }
}

/**
 * Singleton pour gérer l'ensemble des blocks (enregistrement, enqueue, etc.)
 */
class Blocks
{
    private static self $instance;

    // Propriétés éventuellement utilisables plus tard
    public string $block_name = '';
    public array $markers = [];

    // Cache local pour éviter de multiplier les requêtes
    private array $area_blocks = [];

    public static function get_instance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
    }

    /**
     * Lance l'initialisation (hook WP)
     */
    public function init(): void
    {
        $this->init_hooks();
    }

    /**
     * Initialise les hooks WP
     */
    public function init_hooks(): void
    {
        add_action('init', [$this, 'register_blocks'], 999);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_blocks_style']);
        add_action('enqueue_block_assets', [$this, 'enqueue_blocks_editor_style']);
        add_filter('block_categories_all', [$this, 'register_block_category']);
    }

    /**
     * Enregistre la catégorie personnalisée pour les blocks
     */
    public function register_block_category(array $categories): array
    {
        $new_category = [
            'slug' => 'contentify-blocks',
            'title' => 'Blocs Contentify'
        ];

        array_unshift($categories, $new_category);

        return $categories;
    }

    /**
     * Parcourt le dossier /blocks et enregistre chaque block via son block.json
     */
    public function register_blocks(): void
    {
        $blocks = $this->get_blocks();
        if (empty($blocks)) {
            return;
        }

        foreach ($blocks as $block) {
            $block_dir = get_template_directory() . '/blocks/' . $block . '/';
            // On vérifie l'existence de block.json
            if (file_exists($block_dir . 'block.json')) {
                register_block_type($block_dir . 'block.json', []);
            }
        }
    }

    /**
     * Enqueue des fichiers CSS pour l'éditeur (backend)
     */
    public function enqueue_blocks_editor_style(): void
    {
        if (!is_admin()) {
            return;
        }

        $blocks = $this->get_blocks();
        if (empty($blocks)) {
            return;
        }

        foreach ($blocks as $block) {
            $block_dist = DIST_BLOCK . $block . '/';
            $files_path = get_template_directory() . $block_dist;

            // Récupère tous les fichiers CSS (glob peut retourner false si aucun fichier trouvé)
            $css_all_files = glob($files_path . '*.css', GLOB_BRACE) ?: [];
            foreach ($css_all_files as $file_url) {
                // On ne charge pas ici spécifiquement un fichier 'editor' ou non,
                // dans l’éditeur on peut tout charger ou filtrer différemment si besoin
                $block_path = get_template_directory_uri() . $block_dist . basename($file_url);
                $handle = 'block-' . basename($file_url, '.css');

                wp_enqueue_style($handle, $block_path, [], THEME_VERSION);
            }
        }
    }

    /**
     * Vérifie si un block spécifique est présent dans un tableau de blocks parsés
     * (incluant les innerBlocks)
     */
    public function has_block_type(array $parsed_blocks, string $block_name): bool
    {
        foreach ($parsed_blocks as $block) {
            if (($block['blockName'] ?? '') === $block_name) {
                return true;
            }
            if (!empty($block['innerBlocks'])) {
                if ($this->has_block_type($block['innerBlocks'], $block_name)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Récupère le post (archive-template) assigné à un post_type et une zone (before/after)
     */
    public function get_block_area(?string $post_type, ?string $area): ?WP_Post
    {
        if (!$post_type || !$area) {
            return null;
        }

        $key = $post_type . '-' . $area;
        if (array_key_exists($key, $this->area_blocks)) {
            return $this->area_blocks[$key];
        }

        // On utilise '=' au lieu de '===' pour compare (meta_query)
        $args = [
            'posts_per_page' => 1,
            'post_type' => 'archive-template',
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'assigned-post_type',
                    'value' => $post_type,
                    'compare' => '='
                ],
                [
                    'key' => 'assigned-area',
                    'value' => $area,
                    'compare' => '='
                ]
            ]
        ];

        $query = new WP_Query($args);

        if (!$query->have_posts()) {
            $this->area_blocks[$key] = null;
        } else {
            $posts = $query->get_posts();
            $this->area_blocks[$key] = $posts[0] ?? null;
        }

        $block_area_key = $this->area_blocks[$key];

        wp_reset_postdata();


        add_action('admin_bar_menu', function ($wp_admin_bar) use ($block_area_key) {
            if (is_null($block_area_key) || !is_admin() && !is_user_logged_in()) {
                return;
            }

            $assigned_area = get_field('assigned-area', $block_area_key->ID);
            $label_area_position = "";

            switch ($assigned_area) {
                case 'before':
                    $label_area_position = __('Avant contenu', TEXT_DOMAIN);
                    break;
                case 'after':
                    $label_area_position = __('Après contenu', TEXT_DOMAIN);
                    break;
            }

            $parent_id = 'block_areas_edit';

            $wp_admin_bar->add_menu(array(
                'id' => $parent_id,                      // Identifiant unique pour le nœud.
                'title' => __('Editer les modèles', TEXT_DOMAIN),                     // Le texte affiché.
            ));

            $wp_admin_bar->add_menu(array(
                'parent' => $parent_id,                      // Identifiant unique pour le nœud.
                'title' => $label_area_position . ' - ' . $block_area_key->post_title,                     // Le texte affiché.
                'href' => get_edit_post_link($block_area_key->ID),
                'meta' => array(
                    'data-tag' => $label_area_position,                // Classe CSS personnalisable si besoin.
                    'title' => 'Cliquez ici pour éditer cet article' // Texte du tooltip.
                ),
            ));
        }, 100);

        return $this->area_blocks[$key];
    }


    /**
     * Récupère (en les fusionnant) les innerBlocks référencés par 'ref' (patterns/reusable blocks)
     */
    public function get_inner_blocks(array $parsed_blocks): array
    {
        if (empty($parsed_blocks)) {
            return [];
        }

        $compo_ids = array_filter(array_map(function ($block) {
            if (isset($block['attrs']['ref'])) {
                return $block['attrs']['ref'];
            }
            return null;
        }, $parsed_blocks));

        foreach ($compo_ids as $compo_id) {
            $compo = get_post($compo_id);
            if ($compo instanceof WP_Post) {
                $compo_parsed_blocks = parse_blocks($compo->post_content);
                $parsed_blocks = array_merge($parsed_blocks, $compo_parsed_blocks);
            }
        }

        return $parsed_blocks;
    }

    /**
     * Récupère tous les blocks parsés pour la page en cours (page, archive, 404, etc.)
     */
    private function get_parsed_blocks(): array
    {
        $post_type = get_post_type();

        $page_id = 0;

        // Exemples de logique pour déterminer la page courante
        if (is_category()) {
            $page_id = get_option('page_for_posts');
        } elseif (is_home()) {
            $post_type = 'archive-post';
        } elseif (is_archive()) {
            $post_type = 'archive-' . ($post_type ?: 'post');
        } elseif (is_404()) {
            $post_type = 'page-404';
        } else {
            $page_id = get_queried_object_id();
        }

        // On parse le contenu de la page courante si on a un ID
        $content_parsed_blocks = [];
        if (!is_archive() || is_category()) {
            if ($page_id) {
                $page = get_post($page_id);
                if ($page instanceof WP_Post && !empty($page->post_content)) {
                    $content_parsed_blocks = parse_blocks($page->post_content);
                }
            }
        }

        // Récupération des blocks liés à la zone 'before' et 'after'
        $area_block_before = $this->get_block_area($post_type, 'before');
        $area_block_after = $this->get_block_area($post_type, 'after');

        $area_parsed_blocks_before = ($area_block_before instanceof WP_Post)
            ? parse_blocks($area_block_before->post_content)
            : [];
        $area_parsed_blocks_after = ($area_block_after instanceof WP_Post)
            ? parse_blocks($area_block_after->post_content)
            : [];

        // Fusion des blocks, puis récupération des inner blocks éventuels
        $merged_blocks = array_merge(
            $content_parsed_blocks,
            $area_parsed_blocks_before,
            $area_parsed_blocks_after
        );

        return $this->get_inner_blocks($merged_blocks);
    }

    /**
     * Enqueue (front) les CSS/JS nécessaires uniquement si le block est présent sur la page
     */
    public function enqueue_blocks_style(): void
    {
        $parsed_blocks = $this->get_parsed_blocks();

        $blocks = $this->get_blocks();
        if (empty($blocks)) {
            return;
        }

        foreach ($blocks as $block) {
            $block_dist = DIST_BLOCK . $block . '/';
            $files_path = get_template_directory() . $block_dist;
            $block_slug = 'contentify/' . $block;

            // On ne charge les assets que si le block apparaît sur la page
            if ($this->has_block_type($parsed_blocks, $block_slug)) {

                // CSS : on exclut les fichiers contenant '-editor'
                $css_all_files = glob($files_path . '*.css', GLOB_BRACE) ?: [];
                $css_files = array_filter($css_all_files, static function ($file) {
                    return !preg_match('/-editor\.css$/', $file);
                });

                // JS
                $js_files = glob($files_path . '*.js', GLOB_BRACE) ?: [];

                // Enqueue styles
                foreach ($css_files as $file_url) {
                    $block_path = get_template_directory_uri() . $block_dist . basename($file_url);
                    $handle = 'block-' . basename($file_url, '.css');

                    wp_enqueue_style($handle, $block_path, [], THEME_VERSION);
                }

                // Enqueue scripts
                foreach ($js_files as $file_url) {
                    $block_path = get_template_directory_uri() . $block_dist . basename($file_url);
                    $handle = 'block-' . basename($file_url, '.js') . '-js';

                    // On suppose qu'il existe un script "contentify-js" déjà déclaré
                    // ou on peut mettre ['jquery'] ou rien
                    wp_enqueue_script($handle, $block_path, ['contentify-js'], THEME_VERSION, true);
                }
            }
        }
    }

    /**
     * Liste tous les blocks contenus dans le dossier /blocks (en excluant certains noms)
     */
    private function get_blocks(): array
    {
        $blocks_dir = get_template_directory() . '/blocks/';
        if (!is_dir($blocks_dir)) {
            return [];
        }

        $blocks = scandir($blocks_dir);
        if (!is_array($blocks)) {
            return [];
        }

        // On exclut les répertoires/fichiers indésirables
        $exclude = ['..', '.', '.DS_Store', '_base-block'];
        return array_values(array_diff($blocks, $exclude));
    }
}
