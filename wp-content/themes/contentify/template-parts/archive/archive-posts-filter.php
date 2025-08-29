<?php
$ajax_nonce = wp_create_nonce('my_ajax_nonce');

if (get_post_type() == 'faq') {
    $taxonomy = 'type-faq';
} else {
    $taxonomy = 'category';
}

$terms = get_terms(['taxonomy' => $taxonomy, 'parent' => "0"]);

function checkActiveCat($term)
{
    if (isset($_GET['cat'])) {
        $cat_array = explode(',', $_GET['cat']);

        return in_array($term, $cat_array) ? 'active' : '';
    }
    return false;
}

function checkActiveSort($sort = null)
{
    if (isset($_GET['order'])) return $_GET['order'] === $sort ? 'active' : '';

    return false;
}

?>

<?php get_template_part('template-parts/section/top-page'); ?>

<div class="container container-xxlarge">
    <?php echo get_breadcrumb(); ?>
</div>

<div class="actualities large-content" data-nonce="<?php echo esc_attr($ajax_nonce); ?>">
    <!--    <div class="actualities--sorter">-->
    <!--        <div class="container container-xxlarge">-->
    <!--            -->
    <!--        </div>-->
    <!---->
    <!--    </div>-->
    <div class="actualities--posts">
        <div class="container container-xxlarge">
            <div class="actualities--wrapper">
                <div class="posts--filters">
                    <div class="sorter--wrapper">
                        <div class="title sub-title"><i
                                    class="fa-kit fa-filter"></i><?php echo __('Rechercher', TEXT_DOMAIN); ?></div>

                        <input type="search" value="<?php echo $_GET['search'] ?? ''; ?>"
                               placeholder="<?php echo __('Trouver une question', TEXT_DOMAIN); ?>">
                    </div>
                    <div class="filters--head title sub-title icon-arrow"><i
                                class="fa-kit fa-filter"></i><?php echo __('Filtrer', TEXT_DOMAIN); ?></div>
                    <div class="filters--items">
                        <div>
                            <div data-all-cat
                                 class="btn-filter <?php echo isset($_GET['cat']) ? '' : 'active'; ?>"><?php echo __('Toutes', TEXT_DOMAIN); ?></div>

                            <?php foreach ($terms as $term):
                                $term_children_id = get_term_children($term->term_id, $taxonomy);
                                $term_children_id = is_wp_error($term_children_id) ? [] : $term_children_id;
                                ?>
                                <div class="single-filter <?php echo !empty($term_children_id) ? 'has-children' : ''; ?>">
                                    <div class="btn-filter <?php echo checkActiveCat($term->slug); ?>"
                                         data-cat-slug="<?php echo esc_attr($term->slug); ?>">
                                        <?php echo esc_html($term->name); ?>
                                    </div>
                                    <?php if (!empty($term_children_id)): ?>
                                        <div class="children-categories--container">
                                            <ul>
                                                <?php foreach ($term_children_id as $child_id):
                                                    $child_term = get_term($child_id);
                                                    ?>
                                                    <li data-cat-slug="<?php echo esc_attr($child_term->slug); ?>">
                                                        <?php echo esc_html($child_term->name); ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="loading-overlay--container">
                    <div class="posts--container">
                        <?php my_ajax_fetch_actualities(); ?>
                    </div>

                    <div class="loading-overlay">
                        <?php for ($i = 0; $i < DEFAULT_POSTS_PER_PAGE; $i++): ?>
                            <?php get_template_part('template-parts/loop/card-' . get_post_type() . '-loading'); ?>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


