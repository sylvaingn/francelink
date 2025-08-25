<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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

                    <a href="https://status.francelink.net" target="_blank" rel="noopener"
                       class="btn btn-primary"><?php echo __("Notre page de status", TEXT_DOMAIN) ?></a>
            </div>

            <div class="burger">
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