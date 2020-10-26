<?php

/**
 * Adds a custom read more link to all excerpts, manually or automatically generated
 *
 * @param string $post_excerpt Posts's excerpt.
 *
 * @return string
 */
function understrap_all_excerpts_get_more_link( $post_excerpt ) {
    if ( ! is_admin() ) {
        $post_excerpt = $post_excerpt . ' ...';
    }
    return $post_excerpt;
}

/**
  * returns an array of post categories to exclude from common archive queries
  *
  * @return array
  */
  function dc_exclude_posts_from_archives() {

    $categories_to_exclude = array(
       '29', // news
       '25', // press releases
    );

    return $categories_to_exclude;
}

/**
 * displays 3 (by default) most recent posts
 *
 * @param integer $num_posts=3 number of posts to show
 * @return void echos the posts
 */
function dc_get_recent_posts( $num_posts=3 ) {

   $args = array(
       'posts_per_page' => $num_posts , // how many posts to return?
   );

   $recent_posts = new WP_Query( $args ); 

   if ( $recent_posts->have_posts() ) {
       ob_start();

       while ( $recent_posts->have_posts() ) {
           $recent_posts->the_post();

           get_template_part( 'template-parts/sidebar/single' ); 

       }

       echo ob_get_clean();

       wp_reset_query();

   }
}

function dc_get_featured_posts( $num_posts=3 ) {

   $args = array(
       'posts_per_page'    =>  $num_posts,
       'tag'   => 'Featured',
   );

   $most_viewed = new WP_Query( $args ); 

   if ( $most_viewed->have_posts() ) {
       ob_start();

       while ( $most_viewed->have_posts() ) {
           $most_viewed->the_post();

           get_template_part( 'template-parts/sidebar/single' ); 

       }

       echo ob_get_clean();

       wp_reset_query();

   }
}
