<!-- single.php is used for specific a single page only, so we can style and do whatever we want here.  -->
<?php get_header(); ?>


<?php 

    while(have_posts()) {
        the_post();
        ?>
        <h1>This is a page, not a post!</h1>
        <h2><?php the_title(); ?></h2>
        <?php the_content(); ?>
        <hr>
        <?php
    }
?>

<?php get_footer(); ?>