<?php get_header(); ?>

<?php 
// single.php is used for specific a single post blog only, so we can style and do whatever we want here.
?>


<?php 

    while(have_posts()) {
        the_post();
        ?>
        <h2><?php the_title(); ?></h2>
        <?php the_content(); ?>
        <hr>
        <?php
    }
?>

<?php get_footer(); ?>