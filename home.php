<?php
/**
 * post archive
 * 
 * @todo: want to exclude "press release" or "news" category items from the page
 * 
 */

get_header();

global $paged;
?>

<div class="page-title" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/blog-hero.jpg');">
    <div class="overlay">

        <h1 class="white no-margin">Supporting you every step of the way with your service dog or emotional support dog</h1>

    </div>
</div>

<section class="grid-container container-fluid content-area archive" id="primary">

    <?php
    //need this declared outside of the if () so we can use it in the main query regardless
    $sticky_post_ids = [];

    // if we're on the first page of a paginated archive, then let's include Featured Posts (sticky)
    if ( $paged == 0 ) {

        // get first three posts - maybe sticky? 
        $args = array(
            'posts_per_page' => 3,
            'tag'   => 'Featured',
        );
    
        $sticky_posts = new WP_Query( $args );
    
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
        
        // And now let's set things up for the main query, below
        // use "Recent Posts" as loop title
        $loop_title = "Recent Posts";
        
        // & put a border on the top
        $main_class = "site-main page-1";
    } else {
        
        // use "More Posts" as loop title
        $loop_title = "More Posts";
        
        // & don't put a border on the top
        $main_class = "site-main";

    }
    ?>

    <main id="main" class="<?php echo $main_class; ?>">

        <h2><?php echo $loop_title; ?></h2>
        
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
        next_posts_link( 'See More Posts' );
        previous_posts_link( 'Previous Posts' ); 
        ?>
        
    </div>
</section>

<?php
get_footer();