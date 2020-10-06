<?php

	class Review_PostType {
		
		/**
		 * Default c'tor
		 */
		public function __construct(){
			add_action('init', array(&$this, 'createPostType'));
			add_action('admin_init', array(&$this, 'addAdminMeta'));
			add_action('save_post', array(&$this, 'saveAdminMeta'));
			//add_filter('manage_book_posts_columns', array(&$this, 'addTableColumns'));
			//add_filter('manage_book_posts_custom_column', array(&$this, 'populateTableColumns'), 10, 2);
		}
		
		/**
		 * Creates and registers the Character post type
		 */
		public function createPostType(){
			
			//Book Media Post Type
			$args = array( 'labels' => array( 'name' => 'Reviews',
		 										'singular_name' => 'Review',
		 										'add_new' => __( 'Add New' ),
		            							'add_new_item' => __( 'Add New Review'),
		            							'edit_item' => __( 'Edit Review' )),
							'public' => true,
							'publicly_queryable' => false,
							'menu_position' => 5,
							'has_archive' => true,
							'query_var' => false,
							'exclude_from_search' => true,
							'publicly_queryable' => false,
							'taxonomies' => array('category'),
							'supports' => array('title','excerpt'));
							//TODO capabilities
							//TODO supports
							//TODO taxonomies
							//TODO rewrite?
							
		 	register_post_type('review', $args);
		}

		/**
		 * Adds the metabox for custom Character admin fields
		 */
		public function addAdminMeta(){
		 	add_meta_box('review-additional', 'Review Information', array(&$this, 'buildBookMediaAdminMeta'), 'review', 'normal', 'high');
		}
		 
		/**
		 * Creates the HTML for the custom Character admin fields
		 */
		public function buildBookMediaAdminMeta($post){
		 	
			//Add an nonce field so we can check for it later.
		  	wp_nonce_field( 'buildAdminMeta', 'review-addl-nonce' );
			
			//Pull the meta values from the database
			$meta = get_post_meta($post->ID);
			$reviewerTitle = htmlspecialchars($meta['pmb_reviewer_title'][0]);
		 	?>
		 	<fieldset class="pmb-meta-fields pmb-meta-review">
		 		<label for="pmb-reviewer-title">Reviewer Title:</label>
			 	<input id="pmb-reviewer-title" name="pmb-reviewer-title" type="text" value="<?php echo($reviewerTitle); ?>">
		 	</fieldset> 
		 	<?php
		}

		 /**
		  * Saves the custom Character admin meta fields
		  */
		 public function saveAdminMeta($postId){
			
			// Check if our nonce is set.
			if (!isset( $_POST['review-addl-nonce'] ) )
				return $post_id;
			$nonce = $_POST['review-addl-nonce'];
		
			// Verify that the nonce is valid.
			if (!wp_verify_nonce( $nonce, 'buildAdminMeta'))
				return $post_id;
			
			//Don't do anything if this is an autosave
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return($postId);
			
			//Check the user's permissions
			if ('review' !== $_POST['post_type'] || !current_user_can('edit_page', $postId))
				return($postId);

			update_post_meta($postId, 'pmb_reviewer_title', $_POST['pmb-reviewer-title']);
		 }

		/**
		 * Adds custom columns to the Characters post table in the admin section
		 */
		// public function addTableColumns($cols){
// 			
			// $bookCols = array();
			// //Rename the title column and insert the nickname column into the table
			// foreach($cols as $id => $name){
				// if ('title' === $id){
					// $bookCols['title'] = 'Title';
					// $bookCols['subtitle'] = 'Subtitle';
				// } else {
					// $bookCols[$id] = $name;
				// }
			// }
			// return($bookCols);
		// }
	
		/**
		 * Populates the Character custom columns
		 */
		// public function populateTableColumns($colName, $postId){
			// echo($subtitle = get_post_meta($postId, 'pmb_book_media_subtitle', true));
		// }
	}
?>