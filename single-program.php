<?php get_header(); ?>

<?php 
// single.php is used for specific a single post blog only, so we can style and do whatever we want here.
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
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo site_url('/programs '); ?>">
                        <i class="fa fa-home" aria-hidden="true"></i> All Programs
                    </a> 
                    <span class="metabox__main">
                    <?php the_title(); ?>
                    </span>
                </p>
            </div>
            <div class="generic-content">
                <p><?php the_content(); ?></p>

              <?php 

              $relatedProfessors = new WP_Query([
            'posts_per_page' => -1, // if using the value -1, then it will show all posts
            'post_type' => 'professor',
            'orderby' => 'title', // This will be used as professors title name
            'order' => 'ASC',
            'meta_query' => [ // This will allow us to custom/filter the date event 
              [
                  'key' => 'related_programs',
                  'compare' => 'LIKE',
                  'value' => '"' . get_the_id() . '"' // Writing this way will serialize with our id of our page, e.g. program page
              ]
            ]
          ]);

          // Checking if there are any upcoming events here
          if($relatedProfessors -> have_posts()) {
            echo '<hr class="section-break" />';
          echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';
          echo '<ul class="professor-cards">';
          while($relatedProfessors -> have_posts()) {
            $relatedProfessors -> the_post();
            ?>
            <li class="professor-card__list-item">
              <a class="professor-card" href="<?php the_permalink(); ?>">
                <img class="professor-card__image" src="<?php the_post_thumbnail_url('kho_professor_landscape'); ?>" alt="">
                <span class="professor-card__name"><?php the_title(); ?></span>
              </a>
            </li>
            <?php
            }
          } wp_reset_postdata(); // This function reset global post data back to default URL based query, e.g. wordpress/programs/biology
          echo '</ul>';



          $today = date('Ymd');
          $homePageEvents = new WP_Query([
            'posts_per_page' => 2, // if using the value -1, then it will show all posts
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num', // WP meta is all of the extra or custom additional data associated with the post
            'order' => 'ASC',
            'meta_query' => [ // This will allow us to custom the date event 
              [ // this array will give condition if older event post from not today, then it will not display on the GUI
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric' // this will compare the datatype, which is numeric
              ], 
              [
                  'key' => 'related_programs',
                  'compare' => 'LIKE',
                  'value' => '"' . get_the_id() . '"' // Writing this way will serialize with our id
              ]
            ]
          ]);

          // Checking if there are any upcoming events here
          if($homePageEvents -> have_posts()) {
            echo '<hr class="section-break" />';
          echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';

          while($homePageEvents -> have_posts()) {
            $homePageEvents -> the_post();
            ?>
            <div class="event-summary">
              <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                <span class="event-summary__month">
                <?php
                  // the_field() is used in the context of the Advanced Custom Fields plugin 
                  $eventDate = new DateTime(get_field('event_date'));
                  echo $eventDate -> format('M'); 
                 ?>
                 </span>
                <span class="event-summary__day"><?php echo $eventDate -> format('d');  ?></span>  
              </a>
              <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h5>
                <p>
                 <?php 
                if(has_excerpt()) {
                  echo get_the_excerpt();
                  } else {
                    echo wp_trim_words(get_the_content(), 18);
                    }  
                ?> 
                <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
              </div>
            </div>
            <?php
            }
          }
          ?>
            </div>
        </div>
        <?php
    }
?>

<?php get_footer(); ?>