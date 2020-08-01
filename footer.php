<footer class="site-footer">
    <div class="site-footer__inner container container--narrow">
      <div class="group">
        <div class="site-footer__col-one">
          <h1 class="school-logo-text school-logo-text--alt-color"><a href="<?php echo site_url('/'); ?>"><strong>Fictional</strong> University</a></h1>
          <p><a class="site-footer__link" href="#">555.555.5555</a></p>
        </div>

        <div class="site-footer__col-two-three-group">
          <div class="site-footer__col-two">
            <h3 class="headline headline--small">Explore</h3>
            <nav>
              <?php wp_nav_menu(['theme_location' => 'footer-menu-location-one']); ?>
              <!-- <ul class="nav-list min-list">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Programs</a></li>
                <li><a href="#">Events</a></li>
                <li><a href="#">Campuses</a></li>
              </ul> -->
            </nav>
          </div>

          <div class="site-footer__col-three">
            <h3 class="headline headline--small">Learn</h3>
            <nav>
              <?php wp_nav_menu(['theme_location' => 'footer-menu-location-two']); ?>

              <!-- <ul class="nav-list min-list">
                <li><a href="#">Legal</a></li>
                <li><a href="<?php echo site_url('/privacy-policy'); ?>">Privacy</a></li>
                <li><a href="#">Careers</a></li>
              </ul> -->
            </nav>
          </div>
        </div>

        <div class="site-footer__col-four">
          <h3 class="headline headline--small">Connect With Us</h3>
          <nav>
            <ul class="min-list social-icons-list group">
              <li><a href="#" class="social-color-facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
              <li><a href="#" class="social-color-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
              <li><a href="#" class="social-color-youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
              <li><a href="#" class="social-color-linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
              <li><a href="#" class="social-color-instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </footer>

  <div class="search-overlay">
    <div class="search-overlay__top">
      <div class="container">
       <!-- 
          aria-hidden will used for someone who doesn't have good vision. If someone is visiting the website
          This element will not try to read loud to the visitor
        -->
        <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
        <input type="text" id="search-term" class="search-term" placeholder="What are you looking for?">
        <i class="fa fa-window-close  search-overlay__close" aria-hidden="true"></i>
      </div>
    </div>

    <div class="container">
      <div class="search-overlay__results">
        <div data-spinner-loader></div>
        <div class="row">
          <div class="one-third">
            <h2 class="search-overlay__section-title">General Info</h2>
            <ul class="link-list min-list" data-section-general-info></ul>
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Programs</h2>
              <ul class="link-list min-list" data-section-program></ul>
            <h2 class="search-overlay__section-title">Professors</h2>
              <ul class="link-list min-list" data-section-professors></ul>
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Campuses</h2>
            <ul class="link-list min-list" data-section-campuses></ul>

            <h2 class="search-overlay__section-title">Events</h2>
            <ul class="link-list min-list" data-section-events></ul>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- WP can use this for all sorts of things like loading JavaScript Files -->
<?php wp_footer(); ?>
</body>
</html>