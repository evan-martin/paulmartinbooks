<?php
/**
 * Template Name: Characters Archive
 */
get_header();
include_once('sidebar-left.php');
?>
	<section id="primary" class="site-content">
		<div id="content" role="main">
		<?php
		global $post;
		$category = get_post_meta($post->ID, 'pmb_book', true);
		$posts = new WP_Query(array('post_type'=>'character', 'posts_per_page' => -1, 'noapging' => true, 'taxonomy' => 'category', 'term' => $category)); 
		if ( $posts->have_posts() ) :
			/* Start the Loop */
			while ( $posts->have_posts() ) : $posts->the_post();
	
				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
		?>
				<article class="character">
					<div class="entry-content">
						<div class="character-thumb"><?php the_post_thumbnail(); ?></div>
						<div class="character-body">
							<header class="character-name article-title">
								<h1><?php the_title(); ?></h1><h2><?php echo(get_post_meta($post->ID, 'pmb_char_nick', true));?></h2>
							</header>
							<?php the_content(); ?>
						</div>
					</div>
				</article> 
		<?php

			endwhile;

			//twentytwelve_content_nav( 'nav-below' );
			?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>