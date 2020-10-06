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
		<div id="content" class="sns-page" role="main">
			<section id="sns-heading">
					<div id="sns-rating">
					<h3 class="widget-title">Rating System</h3>
					<div class="rating-div">
						<h4 class="emp">Standouts</h4>
						<label class="rank">1 Cheer</label>
						<label class="rank-label">Noteworthy Achiever</label>
						<label class="rank">2 Cheers</label>
						<label class="rank-label">Perennial Paragon</label>
						<label class="rank">3 Cheers</label>
						<label class="rank-label">Virtual Saint</label>
					</div>
					<div class="rating-div">
						<h4 class="emp">Stinkers</h4>
						<label class="rank">1 Jeer</label>
						<label class="rank-label">Slippery Specimen</label>
						<label class="rank">2 Jeers</label>
						<label class="rank-label">Brazen Offender</label>
						<label class="rank">3 Jeers</label>
						<label class="rank-label">Total Monster</label>
					</div>		
				</div>
				<div id="sns-intro" class="sns-section">
					<h2 class="sub-title"><?php echo($isPreview ? '<span style="color:red">Preview </span>' : '') ?>Rating History's</h2>
					<h1 class="emp">Standouts & Stinkers</h1>
					<h3>By the author of <a href="<?php echo(home_url('secret-heroes')) ?>" class="ital">Secret Heroes</a> and <br><a href="<?php echo(home_url('villains')) ?>" class="ital">Villains, Scoundrels, and Rogues</a></h3>
					<p class="instructions">Look for a new character profile each week—and send in your own story ideas! Suggestions must be about lesser-known “Standouts” or “Stinkers” from the past.
						</p>
					<p class="instructions">
						<a href="mailto:paul@paulmartinbooks.com?Subject=Standouts %26 Stinkers">Submit ideas here.</a>
					</p>
				</div>				
			</section>
<section id="sns-profiles" class="sns-section">
				<div class="profiles">
			<?php
					global $post;
					
					$args = array('post_type'=>'sns_pt', 'posts_per_page' => -1, 'noapging' => true);
					if ($isPreview)
						$args['post_status'] = array('publish', 'draft', 'future');
					$posts = new WP_Query($args); 
					if ( $posts->have_posts() ) :
						/* Start the Loop */
						while ( $posts->have_posts() ) : $posts->the_post();
							 $meta = get_post_meta($post->ID);
					?>
							<article class="standout-stinker">
								<div class="entry-content">
									<div class="standout-stinker-body">
										<header class="standout-stinker-title article-title">
											<h1><?php the_title(); ?></h1>
											<h2><?php echo(get_the_date()); ?></h2>
										</header>
										<p>
										<?php 
											$content = get_the_content();
											echo($content);
										?>
										</p>
									</div>
								</div>
							</article> 
					<?php
			
						endwhile;
						?>
			
					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>
					</div>
			</section>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>