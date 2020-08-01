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
function universitySearchResults($data) {
    $main_query = new WP_Query([
        'post_type' => ['post', 'page', 'professor', 'program', 'campus', 'event'], // This will give us multiple Post Types for our query API 
        's' => sanitize_text_field($data['term']), // 's' stands for search, $data is an array and refer to the GET query, e.g. http://localhost/wordpress/wp-json/kho-university/v1/search?term=barksalot
    ]);
        
  
    $results = [
        'general_info' => [   // This is our empty sub-array for general_info

        ],
        'professors' => [ // This is our empty sub-array for professors

        ],
        'programs' => [ // This is our empty sub-array for programs

        ],
        'events' => [ // This is our empty sub-array for events

        ],
        'campuses' => [ // This is our empty sub-array for campuses

        ]
    ];

    while($main_query -> have_posts()) {
        $main_query -> the_post();
        
        if(get_post_type() === 'post' || get_post_type() === 'page') {
            // 1st param: Which array we want to push to
            // 2nd param: Which array we want to add on 
            array_push($results['general_info'], [
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
            ]); 
        }

        if(get_post_type() === 'professor') {
            // 1st param: Which array we want to push to
            // 2nd param: Which array we want to add on 
            array_push($results['professors'], [
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
            ]); 
        }

        if(get_post_type() === 'program') {
            // 1st param: Which array we want to push to
            // 2nd param: Which array we want to add on 
            array_push($results['programs'], [
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
            ]); 
        }

        if(get_post_type() === 'campus') {
            // 1st param: Which array we want to push to
            // 2nd param: Which array we want to add on 
            array_push($results['campuses'], [
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
            ]); 
        }

        if(get_post_type() === 'event') {
            // 1st param: Which array we want to push to
            // 2nd param: Which array we want to add on 
            array_push($results['events'], [
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
            ]); 
        }
       
    }

    return $results;
} 

add_action('rest_api_init', 'kho_university_register_search');

?>