<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
 $left_sidebar_disabled = true;
 global $left_sidebar_disabled;

get_header(); 
?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
					<div class="entry-content">
						<div class="photo">
						<?php the_post_thumbnail();	?>
						<img id="credit-img" src="<?php echo(get_stylesheet_directory_uri()); ?>/images/credits.png" alt="Mark Thiessen/NGS" />
						</div>
						<?php the_content(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post -->
			<?php endwhile; // end of the loop. ?>
			<?php include_once('book-cover-carousel.php'); ?>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>