<?php

/**
 * On enleve les spans que Contact Form 7 génère
 */
add_filter('wpcf7_form_elements', function ($content) {
    $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
    return $content;
});

add_filter( 'wpcf7_allowed_html_tags', function( $tags ) {
    // on autorise désormais l'attribut 'class' sur <label>
    $tags['label']['class'] = true;
    return $tags;
});

add_filter('wpcf7_autop_or_not', '__return_false');

add_filter('wpcf7_form_elements', 'cf7_add_honeypot_field');
function cf7_add_honeypot_field($content)
{
    // The inline style hides it from real users but bots will fill it
    $honeypot = '<label class="cf7-flkhp">
                        <input type="text" name="hp_ad" value="" placeholder="CF7">
                    </label>';
    return $honeypot . $content;
}

// 2) If that field is non-empty, mark as spam (CF7 will abort sending)
add_filter('wpcf7_spam', 'cf7_honeypot_spam_check', 10, 2);
function cf7_honeypot_spam_check($is_spam, $submission)
{
    if (!$submission) {
        $submission = WPCF7_Submission::get_instance();
    }
    if ($submission) {
        $posted = $submission->get_posted_data();
        if (!empty($posted['hp_address'])) {
            return true;   // → treat as spam; mail won’t be sent
        }
    }
    return $is_spam;
}