<?php
/**
 * post archive
 * 
 * @todo: want to exclude "press release" or "news" category items from the page
 * 
 */

get_header();
?>

<div class="page-title" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/blog-hero.jpg');">
    <div class="overlay">

        <h1 class="white no-margin">Supporting you every step of the way with your service dog or emotional support dog</h1>

    </div>
</div>

<section class="grid-container container-fluid content-area archive" id="primary">

    <?php
    // get first three posts - maybe sticky? 
    $args = array(
        'posts_per_page' => 3,
        'tag'   => 'Featured',
    );

    $sticky_posts = new WP_Query( $args );
    $sticky_post_ids = [];

    ob_start();

    if ( $sticky_posts->have_posts() ) :
        ?>
    
            <header class="sticky-posts">

             <?php 
             while ( $sticky_posts->have_posts() ): ?>

                <?php
                $sticky_posts->the_post(); ?>

                <?php
                // load sticky post template
                $holler = get_template_part( 'template-parts/loop/single', 'sticky' ); ?>


                <?php
                // add post ID to array, so we can exclude it in the main loop below
                array_push( $sticky_post_ids, get_the_ID() );
                 
            // end $sticky_posts->have_posts(); 
            endwhile; ?>

         </header>

         <?php
         // end if ( $sticky_posts->have_posts() )
    endif; 
    
    // reset query to get back to the main query
    wp_reset_query();
    ?>


    <main id="main" class="site-main">

        <h2>Recent Posts</h2>
        
        <?php
        // run main loop for remainder of posts, excluding press releases & news
        // $categories_to_exclude = dc_exclude_posts_from_archives();

        $main_args = array(
            'post__not_in'  => $sticky_post_ids,
            'posts_per_page' => 6,

        );
        $main_query = new WP_Query( $main_args );
    
        if ( $main_query->have_posts() ): ?>

            <div class="posts-holder">
                
                <?php
                while ( $main_query->have_posts() ):

                    $main_query->the_post();
                    
                    get_template_part( 'template-parts/loop/single' );

                    // end while $main_query->have_posts()
                endwhile; ?>

            </div>
        
            <?php
            // end if ( $main_query->have_posts() )
        endif; 
        
        // reset query to get back to the main query
        wp_reset_query(); ?>
    </main>

    <div class="load-more-posts">
    
        <?php 
        next_posts_link( 'Load More' );
        previous_posts_link( 'Previous' ); 
        ?>
        
    </div>
</section>

<?php
get_footer();