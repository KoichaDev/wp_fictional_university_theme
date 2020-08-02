<!-- single.php is used for specific a single page only, so we can style and do whatever we want here.  -->
<?php 
    if(!is_user_logged_in()) {
        // Force user to redirect back to the home page if the user is not logged in
        wp_redirect(esc_url(site_url('/')));
        exit; // terminate the script, so it will not use the server resource
    }

    get_header(); 
    while(have_posts()) {
        the_post();
        kho_page_banner();
        ?>               
        <div class="container container--narrow page-section">

            Custom Code will go here        
        </div>

    <?php
    }


    get_footer(); 
?>