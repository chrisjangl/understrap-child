<article class="post-holder">

    <div class="image-holder">
        <a href="<?php echo get_the_permalink(); ?>">
            <?php the_post_thumbnail('large'); ?>
        </a>
    </div>
    <div class="title-holder">
        <h3>
            <a href="<?php echo get_the_permalink(); ?>">
                <?php echo get_the_title(); ?>
            </a>
        </h3>
    </div>
    <div class="date-holder">
        <span class="post-date" >
            <?php $post_date = get_the_date( 'F j, Y' ); echo $post_date;?>
        </span>
    </div>
    <div class="excerpt">
        <?php  the_excerpt(); ?>
    </div>
    <div class="read-more-holder">
        <a class="understrap-read-more-link" href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>">Read Story</a>
    </div>
</article>

<?php
return "oh yeah"; ?>