<?php

	function pmb_booksArchiveShortcode($attributes) {
		
		$args = array('post_type' => 'book', 'post_status' => 'publish', 'nopaging' => true); //TODO ordering
		$posts = new WP_Query($args);
		if ($posts->have_posts()){
			global $post;
			while ( $posts->have_posts() ) : $posts->the_post();
			
			$meta = get_post_meta($post->ID);
			
			$pageLink = $meta['pmb_book_page_link'][0];
			$hasPageLink = ($pageLink && ''!==$pageLink);
?>
			<article class="book entry-content">
				<?php 
					if (has_post_thumbnail($post->ID)){
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
						$imageUrl = $image[0]; 
						
						if ($hasPageLink)
							echo('<a href="'.home_url($pageLink).'">');
				?>
				<img src="<?php echo($imageUrl); ?>" class="attachment-full wp-post-image" alt="<?php the_title(); ?>">
				<?php
						if ($hasPageLink)
							echo('</a>');
					}
				?>
				<div class="book-body">
					<header class="book-name article-title">
						<h1><?php the_title(); ?></h1><h2><?php echo($meta['pmb_book_subtitle'][0]);?></h2>
					</header>
					<span class="book-published"><?php echo($meta['pmb_book_published_by'][0]); ?></span>					
					<p class="book-text">
						<?php echo($meta['pmb_book_quote'][0]); ?>
					</p>
					<p>
						<?php 
							echo('<span class="reviewer-name"/>–'.$meta['pmb_book_quote_author'][0].'</span>');
							if (isset($meta['pmb_book_quote_author_title']) && '' !==$meta['pmb_book_quote_author_title'][0])
								echo(', '.$meta['pmb_book_quote_author_title'][0]);
						?>
					</p>
					<a class="button buy-now" href="<?php echo($meta['pmb_book_purchase_link'][0]); ?>" target="_blank">Buy Now</a>
				</div>
			</article> 		
<?php
			endwhile;
		}
	}
	add_shortcode('pmb_books', 'pmb_booksArchiveShortcode');
	
	
	function pmb_articlesArchiveShortcode($attributes) {
		// extract( shortcode_atts( array(
			// 'attr_1' => 'attribute 1 default',
			// 'attr_2' => 'attribute 2 default',
		// // ...etc
		// ), $atts ) );
		
		$args = array('post_type' => 'article', 'post_status' => 'publish', 'nopaging' => true); //TODO ordering
		$posts = new WP_Query($args);
		if ($posts->have_posts()){
			global $post;
			while ( $posts->have_posts() ) : $posts->the_post();
			
			$meta = get_post_meta($post->ID);
?>
			<article class="entry-content">
			<div class="article">
				<?php the_post_thumbnail(); ?>
				<div class="article-body">
					<header class="article-name article-title">
						<h1><?php the_title(); ?></h1>
					</header>
					<span class="book-published"><?php echo($meta['pmb_book_published_by'][0]); ?></span>					
					<p class="article-excerpt">
						<?php 
							echo($meta['pmb_article_excerpt'][0]); 
							echo(' <a href="'.$meta['pmb_article_link'][0].'" target="_blank">Read more...</a>');//$meta['pmb_article_excerpt'][0]);
						?>
					</p>
					<div class="publisher-info">
						<?php echo('<span class="publisher">'.$meta['pmb_article_publisher'][0].'</span>, '. $meta['pmb_article_publish_date'][0]); ?>
					</div>
				</div>
			</div>
			</article> 		
<?php
			endwhile;
		}
	}
	add_shortcode('pmb_articles', 'pmb_articlesArchiveShortcode');
	
	function pmb_bookMediaArchiveShortcode($attributes) {
		
		//Grab default params
		extract( shortcode_atts( array(
			'category' => 'foo'
		), $attributes ) );
		
		$args = array('post_type' => 'book_media', 'post_status' => 'publish', 'taxonomy' => 'category', 'term' => $category, 'nopaging' => true); //TODO ordering
		$posts = new WP_Query($args);
		if ($posts->have_posts()){
			global $post;
			
			//First group the posts by media outlet type
			$grouped = array("[Uncategorized]" => array());
			$mediaTypes = get_terms('media-outlet-types', 'orderby=id&hide_empty=0');
			foreach($mediaTypes as $id => $outletType)
				$grouped[$outletType->slug] = array();
			
			while ( $posts->have_posts() ) : $posts->the_post();
			
				$selTypes = wp_get_object_terms($post->ID, 'media-outlet-types');
				if (array_key_exists($selTypes[0]->slug, $grouped))
					array_push($grouped[$selTypes[0]->slug], $post);
				else
					array_push($grouped['[Uncategorized]'], $post);
			endwhile;
			
			
			foreach($grouped as $groupId => $group){
				
				if (0>=count($group))
					continue;
				
				echo('<h2 class="section-header">'.ucfirst($groupId).'</h2>');
				foreach($group as $post){
					$meta = get_post_meta($post->ID);
?>
					<article class="book-media entry-content">
						<div class="book-media-body">
							<p class="book-media-title"><?php the_title(); ?><br>
								<span><?php 
											$text = $meta['pmb_book_media_outlet'][0] . ', ' . $meta['pmb_book_media_date'][0];
											if (isset($meta['pmb_book_media_length'][0]) && '' !== trim($meta['pmb_book_media_length'][0]))
												$text .= ' ('.$meta['pmb_book_media_length'][0].')';
											echo($text);
								?></span>
							</p>
							<a class="btn" href="<?php echo($meta['pmb_book_media_link'][0]); ?>" target="_blank"><?php 
									$text = 'Listen';
									switch($groupId){
										case 'television': $text = 'Watch'; break;
										case 'online' : 
											$text = 'Read';
											//Special case
											if ('YouTube.com' === $meta['pmb_book_media_outlet'][0])
												$text = 'Watch'; 
										break; 
									}
									echo($text);
								?></a>
						</div>
					</article> 		
<?php
				}
			}
		}
	}
	add_shortcode('pmb_media', 'pmb_bookMediaArchiveShortcode');
	
	function pmb_reviewsShortcode($attributes) {
		
		//Grab default params
		extract( shortcode_atts( array(
			'category' => 'foo'
		), $attributes ) );
		
		global $post;
		$args = array('post_type' => 'review', 'post_status' => 'publish', 'taxonomy' => 'category', 'term' => $category, 'nopaging' => true); //TODO ordering
		$posts = new WP_Query($args);
		if ($posts->have_posts()){
			
			while ( $posts->have_posts() ) : $posts->the_post();
			$meta = get_post_meta($post->ID);
?>
					<article class="review entry-content">
						<div class="review-body">
							<?php the_excerpt(); ?>
							<p class="reviewer"><span class="reviewer-name">–<?php the_title(); ?></span><span class="reviewer-title"><?php 
											if (isset($meta['pmb_reviewer_title'][0]) && '' !== trim($meta['pmb_reviewer_title'][0])){
												echo(', '. $meta['pmb_reviewer_title'][0]);
											}
								?></span>
							</p>
						</div>
					</article> 		
<?php
			endwhile;
		}
	}
	add_shortcode('pmb_reviews', 'pmb_reviewsShortcode');

?>