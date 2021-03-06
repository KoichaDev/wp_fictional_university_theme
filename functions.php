<?php 
    // functions.php is like having a conversation with the wordpress system itself

    require get_theme_file_path('/includes/search-route.php');

    // Using this argument $args = NULL will give us optional, therefore will not cause error on the site 
    // if there are not arguments required on some pages 
    function kho_page_banner($args = NULL) {
        if(!$args['title']) {
            $args['title'] = get_the_title();
        }

        if(!$args['subtitle']) {
            // get_fied() is used for the Advanced Custom Fields
            $args['subtitle'] = get_field('page_banner_subtitle');
        }

        if(!$args['photo']) {
            // checking if the image has been uploaded Advanced Custom Fields
            if(get_field('page_banner_background_image')) {
                $args['photo'] = get_field('page_banner_background_image')['sizes']['kho_page_banner'];
            } else {
                $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
            }
        }

        ?>
        <div class="page-banner">
            <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>;"></div>
            <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $args['subtitle']; ?></p>
            </div>
            </div>  
        </div>    
        <?php
    }

    function kho_university_files() {
         // Load JavaScript File
        // 4th param: Do you want to load this file right before the closing body tag?
        // wp_enqueue_script('kho_university_script', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);

        // Load CSS files
        wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        // get_stylesheet_uriRetrieves the URI of current theme stylesheet. (WordPress Snippets)
        // wp_enqueue_style('kho_university_styles', get_stylesheet_uri());

        // strstr() checks if a string of text exist in another string of text
        // if you use flywheel, then change for to if(strstr($_SERVER['SERVER_NAME'], 'fictional-university.local')) 
        if(strstr($_SERVER['SERVER_NAME'], 'localhost')) { // this will be for development purpose
            wp_enqueue_script('kho_bundled_university_script', 'http://localhost:3000/bundled.js', NULL, '1.0', true);
        } else { // This will build the production ready for us if we wish to release to the global live 
            wp_enqueue_script('kho_university_vendors_js', get_theme_file_uri('/bundled-assets/vendors~scripts.8c97d901916ad616a264.js') , NULL, '1.0', true);            
            wp_enqueue_script('kho_bundled_university_script', get_theme_file_uri('/bundled-assets/scripts.934700dd502b9bdef7cf.js') , NULL, '1.0', true);            
            wp_enqueue_style('kho_university_styles', get_theme_file_uri('/bundled-assets/styles.934700dd502b9bdef7cf.css'));
        }

        // 1st param: name of the JavaScript file
        // 2nd param: Creating a variable name for the object of the data 
        // 3rd param: Creating an array of data in JavaScript
        wp_localize_script('kho_bundled_university_script', 'kho_university_data', [
            'root_url' => get_site_url(), // Returns the URL of the current WP installation address
            'nonce' => wp_create_nonce('wp_rest') // WP will give user ID to check if the user is logged in or not, so we can perform CRUD operation
        ]);
    } 

    function kho_university_features() {
        // This is to enable website title tag + Site identity based on the page user visits on WP
        add_theme_support('title-tag');
        // This will add the feature images for the WordPress editor
        add_theme_support('post-thumbnails');
        // 1st param: name of the image
        // 2nd param: width
        // 3rd param: height
        // 4th param: crops the image true/false, or giving an array for cropping image position, e.g. ['top', 'left]
        add_image_size('kho_professor_landscape', 400, 260, true);
        add_image_size('kho_professor_portrait', 480, 650, true);
        // This will be used for page background related for example wordpress/professor/dr-mjau
        add_image_size('kho_page_banner', 1500, 350, true);

        // This is to activate our theme, so the user can use the appearance -> menu navigation of the WP dashboard
        register_nav_menu('header-menu-location', 'Header Menu Location'); // 2nd param: optional name for whatever you want
        register_nav_menu('footer-menu-location-one', 'Footer Menu Location One'); // 2nd param: optional name for whatever you want
        register_nav_menu('footer-menu-location-two', 'Footer Menu Location two'); // 2nd param: optional name for whatever you want   
    }

    function kho_university_adjust_queries($query) {

        $today = date('Ymd');

        if(!is_admin() && is_post_type_archive('program') && is_main_query()) {
            $query -> set('orderby', 'title');
            $query -> set('orderby', 'ASC');
            $query -> set('posts_per_page', -1); // -1 will list everything 

        }

        // Checking if the user is not admin + the ur l is e.g. localhost/wordpress/event
        // is_main_query() evaluate only TRUE if the query in question is the default URL based query
        if(!is_admin() && is_post_type_archive('event') && $query -> is_main_query()) {
            // this query will make sure that we want to sort our events to ascending
            $query -> set('meta_key', 'event_date');
            $query -> set('orderby', 'meta_value_num');
            $query -> set('order', 'asc');
            $query -> set('meta_query', [ // This will allow us to custom the date event 
              [ // this array will give condition if older event post from not today, then it will not display on the GUI
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric' // this will compare the datatype, which is numeric
              ]
            ]);
        }
    }

    function kho_university_map($api) {
        $api['key'] = 'AIzaSyBGck_f85GPwhUw2tPan5h8k6_vKqH0NNQ'; 
        return $api;
    }

    function kho_university_custom_restAPI() {
        // Registers a new field on an existing WordPress object type.
        // 1st param: post type we want to customize
        // 2nd param: name the new field of object key-value
        // 3rd param: an array describes how we want to manage this field
        register_rest_field('post', 'author_name', [
            'get_callback' => function() {return get_the_author();}, // returns the author name from the default WP function already created
        ]);

    }

    function redirect_subscribers_to_front_end_page() {
        $our_current_user = wp_get_current_user();
        
        // count is to check how many items is in the array
        // We want to force subscriber to redirect to the homepage. The Admin dashboard doesn't work for them
        if(count($our_current_user -> roles) === 1 && $our_current_user -> roles[0] === 'subscriber') {
            wp_redirect(site_url('/'));
            exit; // Tells PHP to terminate the script
        }
    }

    function no_subscribers_allowed_for_admin_bar() {
        $our_current_user = wp_get_current_user();
        
        // count is to check how many items is in the array
        // We want to force subscriber to redirect to the homepage. The Admin dashboard doesn't work for them
        if(count($our_current_user -> roles) === 1 && $our_current_user -> roles[0] === 'subscriber') {
            // The user will not allowed to see the admin bar at all when they are logged into  the WordPress site
            show_admin_bar(false);
        }
    }

    // Redirect the user to the homepage when clicking on the logo image when they visits the login page. 
    function our_header_url() {
        return esc_url(site_url('/'));
    }

    // Visiting the login page of /wp-login.php will give us ability to customize our CSS
    function our_login_page_css() {
        wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('kho_university_styles', get_theme_file_uri('/bundled-assets/styles.934700dd502b9bdef7cf.css'));
    }

    // Title name for our /wp-login.php
    function our_login_page_title() {
        // return 'Fictional University'; is great for only one site of 
        return get_bloginfo('name'); // This might be used by a lot of different sites
    }

    // add_action() is used for WP hooks event listener
    add_action('wp_enqueue_scripts', 'kho_university_files'); 

    add_action('after_setup_theme', 'kho_university_features');

    // hooks to manipulate default URL based queries
    add_action('pre_get_posts', 'kho_university_adjust_queries');

    // This is the hooks for Advanced Custom Fields
    add_filter('acf/fields/google_map/api', 'kho_university_map');

    add_action('rest_api_init', 'kho_university_custom_restAPI');

    // Redirect subscriber account out of admin and onto homepage
    add_action('admin_init', 'redirect_subscribers_to_front_end_page');

    add_action('wp_loaded', 'no_subscribers_allowed_for_admin_bar');

    // Customize Login Screen
    add_filter('login_headerurl', 'our_header_url');

    // Customize our own CSS for the /wp-login.php page
    add_action('login_enqueue_scripts', 'our_login_page_css');

    add_filter('login_headertitle', 'our_login_page_title');
?>

