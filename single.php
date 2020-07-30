<?php get_header(); ?>

<?php 
// single.php is used for specific a single post blog only, so we can style and do whatever we want here.
?>


<?php 

    while(have_posts()) {
        the_post();
        kho_page_banner();
        ?>
        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>">
                        <i class="fa fa-home" aria-hidden="true"></i> Blog Home
                    </a> 
                    <span class="metabox__main">
                        Posted by <?php the_author_posts_link(); ?> on <?php the_time('j.n.y'); ?> in <?php echo get_the_category_list(', '); ?>
                    </span>
                </p>
            </div>
            <div class="generic-content">
                <p><?php the_content(); ?></p>
            </div>
        </div>
        <?php
    }
?>

<?php get_footer(); ?>