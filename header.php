<!DOCTYPE html>
<!-- language_attributes is to give html tag element which language is displayed on the website -->
<html <?php language_attributes(); ?>> 
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Gives WP control for the head section, such as installing multiple plugins -->
    <?php wp_head(); ?>
</head>
<!-- body_class() gives us dynamically where WP generates class for the body element. We can use it for styling -->
<body <?php body_class(); ?>>

    <header class="site-header">
    <div class="container">
      <h1 class="school-logo-text float-left"><a href="<?php echo site_url('/'); ?>"><strong>Fictional</strong> University</a></h1>
      <a href="<?php esc_url(site_url('/search')); ?>" class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
      <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
      <div class="site-header__menu group">
        <nav class="main-navigation">
          <?php 
            // This will be used for display location 
            wp_nav_menu([
              'theme_location' => 'header-menu-location' 
              ]) 
          ?>

          <!-- This is hard coded. The code above is dynamically based on how users want to arrange the nav menu
          <ul class="min-list group">
            <li><a href="<?php echo site_url('/about-us'); ?>">About Us</a></li>
            <li><a href="#">Programs</a></li>
            <li><a href="#">Events</a></li>
            <li><a href="#">Campuses</a></li>
            <li><a href="#">Blog</a></li>
          </ul> -->
        </nav>
        <div class="site-header__util">
          <a href="#" class="btn btn--small btn--orange float-left push-right">Login</a>
          <a href="#" class="btn btn--small  btn--dark-orange float-left">Sign Up</a>
          <a href="<?php esc_url(site_url('/search')); ?>" class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
        </div>
      </div>
    </div>
  </header>
