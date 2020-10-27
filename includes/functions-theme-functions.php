<?php
/**
 * holds theme customizations & functions
 * 
 * @package Child-theme
 * @subpackage includes
 * 
 */

 /**
  * returns social sharing links: email, facebook, twitter & LinkedIn
  *
  * @return void
  */
function dc_social_share_links() {

	$safe_summary = urlencode( get_the_excerpt() );
	$safe_title = urlencode( get_the_title() );
	$safe_site_name = urlencode( get_bloginfo( 'name' ) );
	$safe_url = urlencode( get_the_permalink() );

	
	$mail_subject = "$safe_site_name%20-%20$safe_title";
	$mail_body = "I thought you might want to read this%3A%20$safe_url";
	$mail_share_url = "mailto:?subject=$mail_subject&body=$mail_body";
	$fb_share_url = "https://www.facebook.com/sharer.php?u=" . $safe_url;
	$twitter_share_url = "https://twitter.com/intent/tweet?url=" . $safe_url . "&text=" . $safe_summary;
	$linkedIn_share_url = "https://www.linkedin.com/shareArticle?mini=true&url=$safe_url&title=$safe_title&summary=$safe_summary&source=$safe_site_name";

	ob_start();
	?>
	<ul class="social-share-links">
        <li class="social-share facebook">
            <a href="<?php echo $fb_share_url;?>" target="_blank"	>
				<i class="fa fa-facebook" ></i>
			</a>
		</li>
		<li class="social-share twitter">
            <a href="<?php echo $twitter_share_url;?>" target="_blank"	>
				<i class="fa fa-twitter" ></i>
			</a>
		</li>
		<li class="social-share linkedin">
            <a href="<?php echo $linkedIn_share_url;?>" target="_blank"	>
				<i class="fa fa-linkedin" ></i>
			</a>
		</li>
        <li>
            <a href="<?php echo $mail_share_url; ?>">
                <i class="fa fa-envelope"></i>
            </a>
        </li>
	</ul>
	<?php

	return ob_get_clean();
} 

function dc_modify_read_more_link() {
    
    global $post;
	return '... <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '">Read Blog</a>';
    
}
// add_filter( 'excerpt_more', 'dc_modify_read_more_link', 99   );