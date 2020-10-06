<?php
/**
 * Template Name: Book Profile
 */
global $post;
$category = get_post_meta($post->ID, 'pmb_book', true);

//TODO HACK
if ('villains' === $category)
	$bookId = 'villains-scoundrels-and-rogues';
else if ('secret_heroes' === $category)
	$bookId = 'secret-heroes';
else if ('trailblazers' === $category)
    $bookId = 'trailblazers';
$books = new WP_Query(array('post_type' => 'book', 'name' => $bookId));
$book = $books->posts[0];
$buyLink = get_post_meta($book->ID, 'pmb_book_purchase_link', true);

get_header();
include_once('sidebar-left.php');
?>
	<div id="primary" class="site-content">
		<div id="content" role="main">
			<div class="cover">
				<div class="photo">
					<img src="<?php echo(get_stylesheet_directory_uri()); ?>/images/<?php echo($category); ?>.jpg" alt="<?php echo($book->post_title); ?>">
				</div>
				<a class="button" href="<?php echo($buyLink); ?>" target="_blank">Buy Now</a>
			</div>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'static' );?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>