<div class="post-item">
    <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

    <div class="generic-content">
    <?php the_excerpt(); ?>
    <p>
        <a href="<?php the_permalink(); ?>" class="btn btn--blue">Continue Reading &raquo;</a>
    </p>
    </div>
</div>