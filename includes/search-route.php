<?php 

function kho_university_register_search() {
    // ! URL: http://localhost/wordpress/wp-json/kho-university/v1/search
    // 1st param: namespace for our custome feature for the URL 
    // 2nd param: namespace for query
    // 3rd param: Array what the REST API should do
    register_rest_route('kho_university/v1', 'search', [
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
        
    // Currently, this is an empty array. This means if we do queries based on the $main_query that we instantiate the class above
    // We will get whatever information and store it on e.g. programs, professors etc.
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
                'post_type' => get_post_type(),
                'author_name' => get_the_author()
            ]); 
        }

        if(get_post_type() === 'professor') {
            // 1st param: Which array we want to push to
            // 2nd param: Which array we want to add on 
            array_push($results['professors'], [
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'post_type' => get_post_type(),
                'author_name' => get_the_author()

            ]); 
        }

        if(get_post_type() === 'program') {
            // 1st param: Which array we want to push to
            // 2nd param: Which array we want to add on 
            array_push($results['programs'], [
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'post_type' => get_post_type(),
                'author_name' => get_the_author()
            ]); 
        }

        if(get_post_type() === 'campus') {
            // 1st param: Which array we want to push to
            // 2nd param: Which array we want to add on 
            array_push($results['campuses'], [
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'post_type' => get_post_type(),
                'author_name' => get_the_author()
            ]); 
        }

        if(get_post_type() === 'event') {
            // 1st param: Which array we want to push to
            // 2nd param: Which array we want to add on 
            array_push($results['events'], [
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'post_type' => get_post_type(),
                'author_name' => get_the_author()
            ]); 
        }

         $program_relationship_query = new WP_Query([
                'post_type' => 'professor',
                'meta_query' => [ // WP let you have multiple inner arrays each one being filter
                    [ 
                        'key' => 'related_programs', // key is the name of the Advanced Custom Field, ergo shortcode of field name
                        'compare' => 'LIKE', // LIKE is comparing-ish. It's not excatly 100% of words we want to search for
                        'value' => '"71"'
                    ]
                ]
            ]);

            while($program_relationship_query -> have_posts()) {
                $program_relationship_query -> the_post();

                if(get_post_type() === 'professor') {
                    // We want to push it to professors, not professor object
                    array_push($results['professors'], [
                        'title' => get_the_title(),
                        'permalink' => get_the_permalink(),
                        'post_type' => get_post_type(),
                        'author_name' => get_the_author()

                    ]); 
                }
            }
    }

    // This will remove duplicated for example author_name 
    // array_values will remove the key number index 
    // SORT_REGULAR - compare items normally (don't change types)
    $results['professor'] = array_values(array_unique($results['professors'], SORT_REGULAR));

    return $results;
} 

add_action('rest_api_init', 'kho_university_register_search');

?>