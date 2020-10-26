<article class="post-holder">

    <div class="image-holder">
        <a href="<?php echo get_the_permalink(); ?>" >
            <?php echo get_the_post_thumbnail( null, 'thumbnail' ); ?>
        </a>
    </div>

    <div class="meta-holder">
        <h3 class="title">
            <a href="<?php echo get_the_permalink(); ?>"  >
                <?php echo get_the_title(); ?>
            </a>
        </h3>
        <span class="post-date">
            <?php echo get_the_date( 'm-d-Y'); ?>
        </span>
    </div>
    <div class="excerpt-holder small-6 cell">
        <?php echo get_the_excerpt(); ?>
    </div>
</article>