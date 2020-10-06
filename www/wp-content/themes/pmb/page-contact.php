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
				<h3 class="widget-title">Recent Works</h3>
                <article class="publicity-div">
					<img src="<?php echo(get_stylesheet_directory_uri()); ?>/images/trailblazers.jpg" alt="American Trailblazers">
					<div class="publisher-info">
                        <p class="reviewer-name">American Trailblazers</p>
						<p class="ital">A Celebration<br>Of All But Forgotten Firsts</p>
                        <a class="button buy-btn" href="https://www.amazon.com/American-Trailblazers-Celebration-Forgotten-Firsts/dp/1979984271/ref=la_B001KIJCJG_1_1_twi_pap_2?s=books&ie=UTF8&qid=1516480288&sr=1-1" target="_blank">Buy Now</a>
					</div>
				</article>
				<article class="publicity-div">
					<img src="<?php echo(get_stylesheet_directory_uri()); ?>/images/villains.jpg" alt="Villains, Scoundrels, and Rogues">
					<div class="publisher-info">
						<p class="reviewer-name">Villains, Scoundrels, and Rogues</p>
						<p class="ital">Incredible True Tales<br>Of Mischief and Mayhem</p>
                        <a class="button buy-btn" href="http://www.randomhouse.com/book/235508/villains-scoundrels-and-rogues-by-paul-martin" target="_blank">Buy Now</a>
					</div>
				</article>
				<article class="publicity-div">
					<img src="<?php echo(get_stylesheet_directory_uri()); ?>/images/secret_heroes.jpg" alt="Villains, Scoundrels, and Rogues">
					<div class="publisher-info">
						<p class="reviewer-name">Secret Heroes</p>
						<p class="ital">Everyday Americans<br>Who Shaped Our World</p>
                        <a class="button buy-btn" href="http://www.harpercollins.com/book/index.aspx?isbn=9780062096050" target="_blank">Buy Now</a>
					</div>
				</article>				
			</section>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>