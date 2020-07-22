<?php 
// functions.php is like having a conversation with the wordpress system itself

    function kho_university_files() {
         // Load JavaScript File
        // 4th param: Do you want to load this file right before the closing body tag?
        wp_enqueue_script('kho_university_script', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);

        // Load CSS files
        wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        // get_stylesheet_uriRetrieves the URI of current theme stylesheet. (WordPress Snippets)
        wp_enqueue_style('kho_university_styles', get_stylesheet_uri());
    } 
?>
<!-- add_action() is used for WP hooks -->
<?php add_action('wp_enqueue_scripts', 'kho_university_files'); ?>