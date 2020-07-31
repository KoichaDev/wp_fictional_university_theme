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

// This function will give us what we want for JSON output
function universitySearchResults() {
    $professors = new WP_Query([
        'post_type' => 'professor'
    ]);

    $professorResults = [];

    while($professors -> have_posts()) {
        $professors -> the_post();
        // 1st param: Which array we want to push to
        // 2nd param: Which array we want to add on 
        array_push($professorResults, [
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            
        ]); 
    }

    return $professorResults;
} 

add_action('rest_api_init', 'kho_university_register_search');

?>