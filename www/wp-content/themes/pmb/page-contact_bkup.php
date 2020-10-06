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
	<div id="primary" class="site-content wrapper">
		<div id="content" class="contact-page" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('contact-form'); ?>>
			
					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post -->
			<?php endwhile; // end of the loop. ?>
			<section id="contact-sidebar">
				<h3 class="widget-title">Publicity</h3>
				<article class="publicity-div">
					<img src="<?php echo(get_stylesheet_directory_uri()); ?>/images/villains.jpg" alt="Villains, Scoundrels, and Rogues">
					<div class="publisher-info">
						<p class="reviewer-name">Meghan F. Quinn</p>
						<p class="ital">Publicist, Prometheus Books</p>
						<p>1-800-853-7545</p>
						<p><a href="mailto:mquinn@prometheusbooks.com?subject=Paul Martin: Villains, Scoundrels, and Rogues" target="_blank">mquinn@prometheusbooks.com</a></p>
					</div>
				</article>
				<article class="publicity-div">
					<img src="<?php echo(get_stylesheet_directory_uri()); ?>/images/secret_heroes.jpg" alt="Villains, Scoundrels, and Rogues">
					<div class="publisher-info">
						<p class="reviewer-name">Kaitlyn Kennedy</p>
						<p class="ital">Publicist, HarperCollins Publishers</p>
						<p>212-207-7745</p>
						<p><a href="mailto:kaitlyn.kennedy@harpercollins.com?subject=Paul Martin: Secret Heroes" target="_blank">kaitlyn.kennedy@harpercollins.com</a></p>
					</div>
				</article>				
			</section>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>