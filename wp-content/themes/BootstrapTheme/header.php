<!DOCTYPE html>
<html>
<head>
    <title><?php wp_title(' | ', true, 'right'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/wordpress/wp-content/themes/BootstrapTheme/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-sm navbar-light bg-light">
    <a class="navbar-brand" href="#">Bootstrap Custom Theme</a>
    <div>
        <?php
        wp_nav_menu([
            'menu' => 'header',
            'container' => '',
            'theme_location' => 'header',
            'items_wrap' => '<ul id="" class="navbar-nav">%3$s</ul>',
        ]);
        ?>
    </div>
</nav>

<div class="text-center mt-3">
    <h1><?php the_title() ?></h1>
</div>