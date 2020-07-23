<?php get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>);"></div>
    <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">
      <?php the_archive_title(); ?>

      <?php 
        // The logic code can be used below, but it will be very hassle when it comes to date formatting as well 
        // Using the code above will give us is_category() + is_author() + date format. Much cleaner!
      ?>
      <!-- <?php if(is_category()) : ?>
        <?php single_cat_title(); ?>
      <?php endif; ?>

      <?php if(is_author()) : ?>
        Posts By <?php the_author(); ?>
      <?php endif; ?> -->
    </h1>
    <div class="page-banner__intro">
      <!-- this function will give the author biography description, category description, etc. -->
      <p><?php the_archive_description(); ?></p>
    </div>
  </div>  
</div>

<div class="container container--narrow page-section">  
<?php 
  while(have_posts()) {
    the_post();
    ?>
    <div class="post-item">
      <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <div class="metabox">
        <?php 
        // Formatting the time and date link of the WP development
        // https://wordpress.org/support/article/formatting-date-and-time/ 
        ?>
        <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('j.n.y'); ?> in <?php echo get_the_category_list(', '); ?></p>
      </div>
      <div class="generic-content">
        <?php the_excerpt(); ?>
        <p>
          <a href="<?php the_permalink(); ?>" class="btn btn--blue">Continue Reading &raquo;</a>
        </p>
      </div>
    </div>
    <?php
  }
  echo paginate_links();
?>
</div>

<?php get_footer(); ?>