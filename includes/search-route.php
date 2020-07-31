<?php 

function kho_university_register_search() {
    // ! URL: http://localhost/wordpress/wp-json/kho-university/v1/search
    // 1st param: namespace for our custome feature for the URL 
    // 2nd param: namespace for query
    // 3rd param: Array what the REST API should do
    register_rest_route('kho-university/v1', 'search', [
        'methods' => WP_REST_SERVER::READABLE, // Core class used to implement the WordPress REST API server. Think of it as CRUD
        'callback' => 'universitySearchResults', // display the RAW JSON placeholder
        
    ]);
}

function universitySearchResults() {
    return 'Congratulations! You created a route!';
} 

add_action('rest_api_init', 'kho_university_register_search');

?>