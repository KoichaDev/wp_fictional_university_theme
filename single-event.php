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
                        <i class="fa fa-home" aria-hidden="true"></i> Events Home
                    </a> 
                    <span class="metabox__main">
                    <?php the_title(); ?>
                    </span>
                </p>
            </div>
            <div class="generic-content">
                <p><?php the_content(); ?></p>
                <?php 
                    // get_field() is used for the Advanced Custom Fields. The param. is used of the field name
                    // Use print_r() to check what datatype is stored in the get_field()
                    $relatedPrograms = get_field('related_programs');
                    
                    if($relatedPrograms) {
                        echo '<ul class="link-list min-list">';
                        echo '<hr class="section-break" />';
                        echo '<h2 class="headline headline--medium">Related Program(s)</h2>';
                        foreach ($relatedPrograms as $program) : ?>
                            <li>
                            <a href="<?php echo get_the_permalink($program); ?>">
                            <?php echo get_the_title($program); ?>
                            </a>
                            </li>
                        <?php endforeach; 
                    }?>
                    </ul>
            </div>
        </div>
        <?php
    }
?>

<?php get_footer(); ?> 