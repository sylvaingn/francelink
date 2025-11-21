<?php
/**
 * comparison-table block
 *
 * @package      ContentifyTheme
 * @subpackage   blocks/comparison-table
 * @author       Sylvain Gounon
 * @since        1.0.0
 **/

/** @var array $block */
$block_obj = new \ContentifyTheme\Blocks\SingleBlock($block);

$fields = $block_obj->get_block_fields();
$plans = $fields['comparison_table-elements'] ?? [];
$sections = $fields['sections'] ?? [];

if (empty($plans) || empty($sections)) return; ?>

<div <?php echo $block_obj->body_block('comparison-table-block'); ?>>
    <div class="container container-xxlarge">
        <?php echo $block_obj->get_block_title('section-title'); ?>

        <div class="comparison-table__head">
            <div class="comparison-table__head-col comparison-table__head-col--empty"></div>

            <?php foreach ($plans as $plan) : ?>
                <div class="comparison-table__head-col">
                    <?php if (!empty($plan['plan_badge'])) : ?>
                        <div class="comparison-table__plan-badge">
                            <?php echo esc_html($plan['plan_badge']); ?>
                        </div>
                    <?php endif; ?>

                    <h3 class="comparison-table__plan-title">
                        <?php echo esc_html($plan['plan_name']); ?>
                    </h3>

                    <?php if (!empty($plan['plan_subtitle'])) : ?>
                        <p class="comparison-table__plan-subtitle">
                            <?php echo esc_html($plan['plan_subtitle']); ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($plan['plan_price'])) : ?>
                        <p class="comparison-table__plan-price">
                            <?php echo esc_html($plan['plan_price']); ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($plan['plan_cta_label']) && !empty($plan['plan_cta_url'])) : ?>
                        <a href="<?php echo esc_url($plan['plan_cta_url']); ?>"
                           class="comparison-table__plan-cta">
                            <?php echo esc_html($plan['plan_cta_label']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="comparison-table__body">
            <?php foreach ($sections as $section) : ?>
                <div class="comparison-table__section">
                    <div class="comparison-table__section-header">
                        <h4 class="comparison-table__section-title">
                            <?php echo esc_html($section['section_title']); ?>
                        </h4>
                        <?php if (!empty($section['section_description'])) : ?>
                            <p class="comparison-table__section-description">
                                <?php echo esc_html($section['section_description']); ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($section['rows'])) : ?>
                        <?php foreach ($section['rows'] as $row) : ?>
                            <div class="comparison-table__row">
                                <div class="comparison-table__row-label">
                                    <span class="comparison-table__row-title">
                                        <?php echo esc_html($row['row_label']); ?>
                                    </span>
                                    <?php if (!empty($row['row_help'])) : ?>
                                        <span class="comparison-table__row-help">
                                            <?php echo esc_html($row['row_help']); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <?php
                                $row_values = !empty($row['row_values']) ? $row['row_values'] : [];
                                $row_display_type = !empty($row['row_display_type']) ? $row['row_display_type'] : 'text';

                                // On boucle sur les plans, et on prend la valeur qui a le même index
                                foreach ($plans as $index => $plan) :
                                    $value = isset($row_values[$index]) ? $row_values[$index] : null;
                                    $text = $value && !empty($value['value_text']) ? $value['value_text'] : '';
                                    $note = $value && !empty($value['value_note']) ? $value['value_note'] : '';
                                    $highlight = $value && !empty($value['value_highlight']);
                                    ?>
                                    <div class="comparison-table__cell<?php echo $highlight ? ' comparison-table__cell--highlight' : ''; ?>">
                                        <?php if ($row_display_type === 'check') : ?>
                                            <?php if ($text === '' || $text === '1' || strtolower($text) === 'yes') : ?>
                                                <span class="comparison-table__cell-check">✓</span>
                                            <?php else : ?>
                                                <span class="comparison-table__cell-text">
                                                    <?php echo esc_html($text); ?>
                                                </span>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <span class="comparison-table__cell-text">
                                                <?php echo esc_html($text); ?>
                                            </span>
                                        <?php endif; ?>

                                        <?php if ($note) : ?>
                                            <span class="comparison-table__cell-note">
                                                <?php echo esc_html($note); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>