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
