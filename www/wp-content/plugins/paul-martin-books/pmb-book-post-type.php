<?php

	class Book_PostType {
		
		/**
		 * Default c'tor
		 */
		public function __construct(){
			add_action('init', array(&$this, 'createPostType'));
			add_action('admin_init', array(&$this, 'addAdminMeta'));
			add_action('save_post', array(&$this, 'saveAdminMeta'));
			add_filter('manage_book_posts_columns', array(&$this, 'addTableColumns'));
			add_filter('manage_book_posts_custom_column', array(&$this, 'populateTableColumns'), 10, 2);
		}
		
		/**
		 * Creates and registers the Character post type
		 */
		public function createPostType(){
			$args = array( 'labels' => array( 'name' => 'Books',
		 										'singular_name' => 'Book',
		 										'add_new' => __( 'Add New' ),
		            							'add_new_item' => __( 'Add New Book'),
		            							'edit_item' => __( 'Edit Book' )),
							'public' => true,
							'publicly_queryable' => false,
							'menu_position' => 5,
							'has_archive' => true,
							'query_var' => false,
							'exclude_from_search' => true,
							'publicly_queryable' => false,
							'supports' => array('title', 'thumbnail'));
							//TODO capabilities
							//TODO supports
							//TODO taxonomies
							//TODO rewrite?
							
		 	register_post_type('book', $args);
		}

		/**
		 * Adds the metabox for custom Character admin fields
		 */
		public function addAdminMeta(){
		 	add_meta_box('book-additional', 'Book Information', array(&$this, 'buildBookAdminMeta'), 'book', 'normal', 'high');
		}
		 
		/**
		 * Creates the HTML for the custom Character admin fields
		 */
		public function buildBookAdminMeta($post){
		 	
			//Add an nonce field so we can check for it later.
		  	wp_nonce_field( 'buildAdminMeta', 'book-addl-nonce' );
			
			//Pull the meta values from the database
			$meta = get_post_meta($post->ID);
			
			$quote = htmlspecialchars($meta['pmb_book_quote'][0]);
			$quoteAuthor = htmlspecialchars($meta['pmb_book_quote_author'][0]);
		 	?>
		 	<fieldset class="pmb-meta-fields pmb-meta-books">
		 		<label for="pmb-book-subtitle">Sub-title:</label>
			 	<input id="pmb-book-subtitle" name="pmb-book-subtitle" type="text" value="<?php echo($meta['pmb_book_subtitle'][0]); ?>">
			 	<label for="pmb-book-purchase-link">Purchase Link:</label>
			 	<input id="pmb-book-purchase-link" name="pmb-book-purchase-link" type="text" value="<?php echo($meta['pmb_book_purchase_link'][0]); ?>">
			 	<label for="pmb-book-published-by">Published By:</label>
			 	<input id="pmb-book-published-by" name="pmb-book-published-by" type="text" value="<?php echo($meta['pmb_book_published_by'][0]); ?>">
			 	<label for="pmb-book-quote">Quote:</label>
			 	<textarea id="pmb-book-quote" name="pmb-book-quote" type="text"><?php echo($quote); ?></textarea>
			 	<label for="pmb-book-quote-author">Quote Author:</label>
			 	<input id="pmb-book-quote-author" name="pmb-book-quote-author" type="text" value="<?php echo($quoteAuthor); ?>">
			 	<label for="pmb-book-quote-author-title">Quote Author Title:</label>
			 	<input id="pmb-book-quote-author-title" name="pmb-book-quote-author-title" type="text" value="<?php echo($meta['pmb_book_quote_author_title'][0]); ?>">
			 	<label for="pmb-book-page-link">Link to Page:</label>
			 	<input id="pmb-book-page-link" name="pmb-book-page-link" type="text" value="<?php echo($meta['pmb_book_page_link'][0]); ?>">			 	
		 	</fieldset> 
		 	<?php
		}

		 /**
		  * Saves the custom Character admin meta fields
		  */
		 public function saveAdminMeta($postId){
			
			// Check if our nonce is set.
			if (!isset( $_POST['book-addl-nonce'] ) )
				return $post_id;
			$nonce = $_POST['book-addl-nonce'];
		
			// Verify that the nonce is valid.
			if (!wp_verify_nonce( $nonce, 'buildAdminMeta'))
				return $post_id;
			
			//Don't do anything if this is an autosave
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return($postId);
			
			//Check the user's permissions
			if ('book' !== $_POST['post_type'] || !current_user_can('edit_page', $postId))
				return($postId);
			
			update_post_meta($postId, 'pmb_book_subtitle', sanitize_text_field($_POST['pmb-book-subtitle']));
			update_post_meta($postId, 'pmb_book_purchase_link', sanitize_text_field($_POST['pmb-book-purchase-link']));
			update_post_meta($postId, 'pmb_book_published_by', sanitize_text_field($_POST['pmb-book-published-by']));
			update_post_meta($postId, 'pmb_book_quote', $_POST['pmb-book-quote']);
			update_post_meta($postId, 'pmb_book_quote_author', $_POST['pmb-book-quote-author']);
			update_post_meta($postId, 'pmb_book_quote_author_title', sanitize_text_field($_POST['pmb-book-quote-author-title']));
			update_post_meta($postId, 'pmb_book_page_link', sanitize_text_field($_POST['pmb-book-page-link']));
		 }

		/**
		 * Adds custom columns to the Characters post table in the admin section
		 */
		public function addTableColumns($cols){
			
			$bookCols = array();
			//Rename the title column and insert the nickname column into the table
			foreach($cols as $id => $name){
				if ('title' === $id){
					$bookCols['title'] = 'Title';
					$bookCols['subtitle'] = 'Subtitle';
				} else {
					$bookCols[$id] = $name;
				}
			}
			return($bookCols);
		}
	
		/**
		 * Populates the Character custom columns
		 */
		public function populateTableColumns($colName, $postId){
			echo($subtitle = get_post_meta($postId, 'pmb_book_subtitle', true));
		}
	}
?>