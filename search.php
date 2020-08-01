<?php 
  get_header();
  kho_page_banner([
    'title' => 'Search results',
    'subtitle' => 'You searched for &ldquo;' . esc_html(get_search_query(false)) . '"&rdquo;' //  esc_html(get_search_query(false)) will secure our website for no XSS-attack
  ]); 
?>

<div class="container container--narrow page-section">  
<?php 

    if(have_posts()) {
        while(have_posts()) {
            the_post();
            // Using this method will give us dynamically post type instead of we have to hardcode like if(get_post_type() === 'professor')
            get_template_part('template-parts/content', get_post_type());
        }
        echo paginate_links();
    } else {
        echo '<h2 class="headline headline--small--plus">No results match that search.</h2>';
    }

    get_search_form();
  
?>
</div>

<?php get_footer(); ?>