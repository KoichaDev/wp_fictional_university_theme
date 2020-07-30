<?php
  get_header();
  kho_page_banner([
    'title' => 'Past Events!',
    'subtitle' => 'A recap of our past events'
  ]);  
?>

<div class="container container--narrow page-section">  
<?php 
  
  $today = date('Ymd');
  $pastEvents = new WP_Query([
    'paged' => get_query_var('paged', 1), // This function can be used to get all sorts of information about the current URL
    // 'posts_per_page' => 1,
    'post_type' => 'event',
    'meta_key' => 'event_date',
    'orderby' => 'meta_value_num', // WP meta is all of the extra or custom additional data associated with the post
    'order' => 'ASC',
    'meta_query' => [ // This will allow us to custom the date event 
      [ // this array will give condition if older event post from not today, then it will not display on the GUI
        'key' => 'event_date',
        'compare' => '<=',
        'value' => $today,
        'type' => 'numeric' // this will compare the datatype, which is numeric
      ]
    ]
  ]);

  while($pastEvents -> have_posts()) {
    $pastEvents -> the_post();
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
        <?php echo wp_trim_words(get_the_content(), 18) ?>
        <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
        </div>
    </div>
    <?php
  }
  echo paginate_links([
    'total' => $pastEvents -> max_num_pages // This will give us specific past event pagination
  ]);
?>
</div>

<?php get_footer(); ?>