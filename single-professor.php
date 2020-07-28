<?php get_header(); ?>

<?php 
// single.php is used for specific a single page for professor only, so we can style and do whatever we want here.
?>
<?php 

    while(have_posts()) {
        the_post();
        ?>
        <div class="page-banner">
            <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>);"></div>
            <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
            <div class="page-banner__intro">
                <p>DON'T FORGET TO REPLACE ME LATER!</p>
            </div>
            </div>  
        </div>
        <div class="container container--narrow page-section">
            <div class="generic-content">
                <div class="row group">
                    <div class="one-third">
                        <?php the_post_thumbnail('kho_professor_portrait'); ?>
                    </div>

                    <div class="two-thirds">
                        <?php the_content(); ?>
                    </div>

                </div>
                <?php 
                    // get_field() is used for the Advanced Custom Fields. The param. is used of the field name
                    // Use print_r() to check what datatype is stored in the get_field()
                    $relatedPrograms = get_field('related_programs');
                    
                    if($relatedPrograms) {
                        echo '<ul class="link-list min-list">';
                        echo '<hr class="section-break" />';
                        echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
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