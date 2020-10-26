<?php
/**
 * The template for displaying all single posts
 * 
 * @todo: integrate sidebar into left-sidebar & right-sidebar checks
 * @todo: pagination
 * @todo: comments?
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="<?php echo esc_attr( $container ); ?>" id="content">

	<div class="row">

        <!-- Do the left sidebar check -->
        <?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

		<article class="inner-content">

			
			<main class="site-main main small-12 medium-7" id="main">
				
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
				<div class="image-and-sharing">

					<div class="featured-image-holder">
						<?php the_post_thumbnail('full'); ?>
					</div>
					
					<aside class="social-share-holder">
						<?php echo dc_social_share_links(); ?>
					</aside>
				</div>

				<div class="post-meta">
					<div class="category-holder">
						<?php 
						$categories = get_the_category();
						echo $categories[0]->name; ?>
					</div>

					<div class="title-holder">
						<h1 class="title"> <?php the_title(); ?></h1>
					</div>

					<div class="date-holder">
						<span class="date"><?php $post_date = get_the_date( 'm-d-Y' ); echo $post_date;?></span>
					</div>

				</div>

				<div class="content-holder">
					
					<?php the_content(); ?>
					
				</div>

				<?php endwhile; endif; ?>


			</main>

			<?php
			// post navigation
			understrap_post_nav(); 	?>

            <?php
            // @todo: integrate this into the sidebar check above ?>
			<!-- <aside class="cell medium-4"> -->
				<?php // sidebar - recent & most read posts
				//get_template_part( 'sidebar' ); ?>
			<!-- </aside> -->
			
        </article>
		
		<!-- Do the right sidebar check -->
		<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

	</div>

	
</div>
<?php get_footer();?>
				
 