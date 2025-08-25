<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>


<header id="masthead">
    <div class="container container-xxlarge">
        <div class="masthead--wrapper">
            <a href="<?php echo get_home_url(); ?>" class="site-logo"
               style="--logo-url:url('<?php echo getCustomLogoUrl(); ?>');">
            </a>
            <div class="wrapper--nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'menu-primary',
                    'container' => false,
                    'menu_class' => '',
                    'items_wrap' => '<nav><ul class="menu menu-primary">%3$s</ul></nav>',
                ));
                ?>

                <?php
                $billeterie_link = get_field('billeterie-page', 'options');

                if (isset($billeterie_link) && $billeterie_link != ''): ?>
                    <a href="<?php echo $billeterie_link; ?>"
                       class="btn"><?php echo __("Billeterie", TEXT_DOMAIN) ?></a>
                <?php endif; ?>
            </div>

            <div class="burger">
                <svg width="40" height="41" viewBox="0 0 40 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path id="line-bot"
                          d="M36.0547 29.4152L4.00006 29.4152L4.00007 37.3102L24.6762 37.3102L36.0547 34.9912L36.0547 29.4152Z"
                          fill="#2B2B42"/>
                    <path id="line-mid"
                          d="M36.0547 16.52L4.00006 16.52L4.00007 24.4151L24.6762 24.4151L36.0547 22.096L36.0547 16.52Z"
                          fill="#2B2B42"/>
                    <path id="line-top"
                          d="M36.0547 3.625L4.00006 3.625L4.00007 11.5201L24.6762 11.5201L36.0547 9.201L36.0547 3.625Z"
                          fill="#2B2B42"/>
                </svg>
            </div>
        </div>
    </div>
    <div id="masthead--burger" class="dashed-border top">
        <div class="container">
            <div class="burger--wrapper">
                test
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'menu-primary',
                    'container' => false,
                    'menu_class' => '',
                    'items_wrap' => '<nav><ul class="menu menu-primary">%3$s</ul></nav>',
                ));
                ?>
            </div>
        </div>
    </div>
</header>


<main id="content">