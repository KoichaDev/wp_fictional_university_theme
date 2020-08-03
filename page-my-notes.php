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
            <ul class="min-list link-list" data-my-notes>
                <?php 
                    $user_notes = new WP_Query([
                        'post_type' => 'note',
                        'post_per_page' => -1, // Display all posts of the notes
                        'author' => get_current_user_id(), // Only get the author name from the user that is logged in
                    ]);

                    while($user_notes -> have_posts()) {
                        $user_notes -> the_post();
                        ?>
                            <!-- the_id() Display the ID of the current item in the WordPress Loop. -->
                            <li data-id="<?php the_ID(); ?>">
                            <!-- When using information from the WP Database of HTML attribute, we have to secure it -->
                            <input readonly class="note-title-field" value="<?php echo esc_attr(get_the_title()); ?>">
                            <span class="edit-note" data-edit-note>
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                Edit
                            </span>
                            <span class="delete-note" data-delete-button>
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                Delete
                            </span>

                            <!-- wp_strip_all_tags() Properly strip all HTML tags including script and style -->
                            <textarea readonly class="note-body-field"><?php echo esc_attr(wp_strip_all_tags(get_the_content())); ?></textarea>
                            </li>
                        <?php
                    }
                ?>

            </ul>
        </div>

    <?php
    }

    get_footer(); 
?>