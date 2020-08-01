<!-- single.php is used for specific a single page only, so we can style and do whatever we want here.  -->
<?php 
    get_header(); 
    while(have_posts()) {
        the_post();
        kho_page_banner([
            'title' => 'Hello This is the title',
            'subtitle' => 'Hi this is the subtitle',
            'photo' => ''
        ]);
        ?>               

        <div class="container container--narrow page-section">

            <div class="metabox metabox--position-up metabox--with-home-link">
            <?php $theParent = wp_get_post_parent_id(get_the_ID()); ?>
            <?php if($theParent) : ?>
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?>
                </a> <span class="metabox__main"><?php the_title(); ?></span>
            </p>
            <?php endif; ?>
        </div>
            <?php 
            $testArr = get_pages([ // If no current page has children, will just return NULL or false
                'child_of' => get_the_ID(), // Checking if the current page has children
            ]);
            if($theParent || $testArr) : ?>
        <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>"><?php echo get_the_title($theParent); ?></a></h2>
        <ul class="min-list">
            <?php 
            if($theParent) {
                $findChildrenOf = $theParent;
            } else {
                $findChildrenOf = get_the_ID();
            }
            // Very similiar to get_pages(). Difference is the function below will handle the output vs get_pages() only returns
            wp_list_pages([
                'title_li' => NULL, // This removes the title, since we don't want the title of our li to anything
                'child_of' => $findChildrenOf,
                'sort_column' => 'menu_order' // This will make user to choose manually how to order to display on the row from Page attribute on the editor
            ]);  
            ?>
        </ul>
        </div>
            <?php endif; ?>


            <div class="generic-content">
                <?php get_search_form(); ?>
            </div>
        </div>
        <?php
    }


    get_footer(); 
?>