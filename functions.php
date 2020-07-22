<?php 
// functions.php is like having a conversation with the wordpress system itself

    function kho_university_files() {
        // Load CSS file
        // get_stylesheet_uriRetrieves the URI of current theme stylesheet. (WordPress Snippets)
        wp_enqueue_style('kho_university_styles', get_stylesheet_uri());
    } 
?>
<!-- add_action() is used for WP hooks -->
<?php add_action('wp_enqueue_scripts', 'kho_university_files'); ?>