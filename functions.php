<?php 
// functions.php is like having a conversation with the wordpress system itself

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
            wp_enqueue_script('kho_university_script', get_theme_file_uri('/bundled-assets/scripts.1b2bda0ef30dedd299a9.js') , NULL, '1.0', true);            
            wp_enqueue_style('kho_university_styles', get_theme_file_uri('/bundled-assets/styles.1b2bda0ef30dedd299a9.css'));
        }

    } 

    function kho_university_features() {
        // This is to enable website title tag + Site identity based on the page user visits on WP
        add_theme_support('title-tag');
        // This will add the feature images for the WordPress editor
        add_theme_support('post-thumbnails');
        // 1st param: name of the image
        // 2nd param: width
        // 3rd param: height
        // 4th param: crops the image or not
        add_image_size('kho_professor_landscape', 400, 260, true);
        add_image_size('kho_professor_portrait', 480, 650, true);

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

    // add_action() is used for WP hooks event listener
    add_action('wp_enqueue_scripts', 'kho_university_files'); 

    add_action('after_setup_theme', 'kho_university_features');

    // hooks to manipulate default URL based queries
    add_action('pre_get_posts', 'kho_university_adjust_queries');

?>

