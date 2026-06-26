<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
<meta charset="<?php bloginfo('charset'); ?>">

<meta name="viewport" content="width=device-width, initial-scale=1">

<?php wp_head(); ?>

</head>


<body <?php body_class(); ?>>

<header class="site-header">

    <h1>
        SmartPost Canada
    </h1>

    <p>
        Enterprise Postal Management Portal
    </p>

</header>


<nav class="main-menu">

<?php

wp_nav_menu(
    array(
        'theme_location' => 'primary'
    )
);

?>

</nav>


<div class="content-area">