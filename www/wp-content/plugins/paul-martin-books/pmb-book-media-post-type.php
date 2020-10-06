<?php

	class BookMedia_PostType {
		
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
			
			$args = array('labels' => array('name' => 'Media Outlet Types',
										'singular_name' => 'Media Outlet Type'),
										'show_admin_column' => true,
										'heirarchical' => true,
										'sort' => true,
										'show_in_nav_menus'  => false,
										'query_var' => false);
			register_taxonomy( 'media-outlet-types', 'book_media', $args);
			
			//Book Media Post Type
			$args = array( 'labels' => array( 'name' => 'Book Media',
		 										'singular_name' => 'Book Media',
		 										'add_new' => __( 'Add New' ),
		            							'add_new_item' => __( 'Add New Book Media'),
		            							'edit_item' => __( 'Edit Book Media' )),
							'public' => true,
							'publicly_queryable' => false,
							'menu_position' => 5,
							'has_archive' => true,
							'query_var' => false,
							'exclude_from_search' => true,
							'publicly_queryable' => false,
							'taxonomies' => array('category', 'media-outlet-types'),
							'supports' => array('title'));
							//TODO capabilities
							//TODO supports
							//TODO taxonomies
							//TODO rewrite?
							
		 	register_post_type('book_media', $args);
		}

		/**
		 * Adds the metabox for custom Character admin fields
		 */
		public function addAdminMeta(){
		 	add_meta_box('book-media-additional', 'Book Information', array(&$this, 'buildBookMediaAdminMeta'), 'book_media', 'normal', 'high');
		}
		 
		/**
		 * Creates the HTML for the custom Character admin fields
		 */
		public function buildBookMediaAdminMeta($post){
		 	
			//Add an nonce field so we can check for it later.
		  	wp_nonce_field( 'buildAdminMeta', 'book-media-addl-nonce' );
			
			//Pull the meta values from the database
			$meta = get_post_meta($post->ID);
			
		 	?>
		 	<fieldset class="pmb-meta-fields pmb-meta-books">
		 		<label>Media Type:</label>
		 		<div class="radio-group">
			<?php
				$mediaTypes = get_terms('media-outlet-types', 'orderby=id&hide_empty=0');
				$selTypes = wp_get_object_terms($post->ID, 'media-outlet-types');
				if (0===count($selTypes))
					array_push($selTypes, $mediaTypes[0]);	

				foreach($mediaTypes as $id => $mediaType){
					echo('<input id="term_'.$id.'" type="radio" name="media-type-radio-group" '.(($mediaType->slug === $selTypes[0]->slug) ? ' checked' : '').' value="'.$mediaType->slug.'"><label for="term_'.$id.'">'.$mediaType->name.'</label>');
				}
			?>	</div>
		 		<label for="pmb-book-media-outlet">Media Outlet:</label>
			 	<input id="pmb-book-media-outlet" name="pmb-book-media-outlet" type="text" value="<?php echo($meta['pmb_book_media_outlet'][0]); ?>">
			 	<label for="pmb-book-media-link">View Link:</label>
			 	<input id="pmb-book-media-link" name="pmb-book-media-link" type="text" value="<?php echo($meta['pmb_book_media_link'][0]); ?>">
			 	<label for="pmb-book-media-date">Date:</label>
			 	<input id="pmb-book-media-date" name="pmb-book-media-date" type="text" value="<?php echo($meta['pmb_book_media_date'][0]); ?>">			 	
			 	<label for="pmb-book-media-length">Running Time:</label>
			 	<input id="pmb-book-media-length" name="pmb-book-media-length" type="text" value="<?php echo($meta['pmb_book_media_length'][0]); ?>">
		 	</fieldset> 
		 	<?php
		}

		 /**
		  * Saves the custom Character admin meta fields
		  */
		 public function saveAdminMeta($postId){
			
			// Check if our nonce is set.
			if (!isset( $_POST['book-media-addl-nonce'] ) )
				return $post_id;
			$nonce = $_POST['book-media-addl-nonce'];
		
			// Verify that the nonce is valid.
			if (!wp_verify_nonce( $nonce, 'buildAdminMeta'))
				return $post_id;
			
			//Don't do anything if this is an autosave
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return($postId);
			
			//Check the user's permissions
			if ('book_media' !== $_POST['post_type'] || !current_user_can('edit_page', $postId))
				return($postId);
			
			update_post_meta($postId, 'pmb_book_media_outlet', sanitize_text_field($_POST['pmb-book-media-outlet']));
			update_post_meta($postId, 'pmb_book_media_link', sanitize_text_field($_POST['pmb-book-media-link']));
			update_post_meta($postId, 'pmb_book_media_date', sanitize_text_field($_POST['pmb-book-media-date']));
			update_post_meta($postId, 'pmb_book_media_length', sanitize_text_field($_POST['pmb-book-media-length']));
			wp_set_object_terms($postId, sanitize_text_field($_POST['media-type-radio-group']), 'media-outlet-types');
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
			echo($subtitle = get_post_meta($postId, 'pmb_book_media_subtitle', true));
		}
	}
?>