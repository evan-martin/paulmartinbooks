<?php

	class Article_PostType {
		
		/**
		 * Default c'tor
		 */
		public function __construct(){
			add_action('init', array(&$this, 'createPostType'));
			add_action('admin_init', array(&$this, 'addAdminMeta'));
			add_action('save_post', array(&$this, 'saveAdminMeta'));
		}
		
		/**
		 * Creates and registers the Character post type
		 */
		public function createPostType(){
			$args = array( 'labels' => array( 'name' => 'Articles',
		 										'singular_name' => 'Article',
		 										'add_new' => __( 'Add New' ),
		            							'add_new_item' => __( 'Add New Article'),
		            							'edit_item' => __( 'Edit Article' )),
							'public' => true,
							'publicly_queryable' => false,
							'menu_position' => 5,
							'has_archive' => true,
							'query_var' => false,
							'exclude_from_search' => true,
							'publicly_queryable' => false,
							'supports' => array('title','thumbnail'));
							//TODO capabilities
							//TODO supports
							//TODO taxonomies
							//TODO rewrite?
							
		 	register_post_type('article', $args);
		}

		/**
		 * Adds the metabox for custom Character admin fields
		 */
		public function addAdminMeta(){
		 	add_meta_box('article-additional', 'Article Information', array(&$this, 'buildArticleAdminMeta'), 'article', 'normal', 'high');
		}
		 
		/**
		 * Creates the HTML for the custom Character admin fields
		 */
		public function buildArticleAdminMeta($post){
		 	
			//Add an nonce field so we can check for it later.
		  	wp_nonce_field( 'buildAdminMeta', 'article-addl-nonce' );
			
			//Pull the meta values from the database
			$meta = get_post_meta($post->ID);
		 	?>
		 	<fieldset class="pmb-meta-fields pmb-meta-article">
		 		<label for="pmb-article-link">Article Link:</label>
			 	<input id="pmb-article-link" name="pmb-article-link" type="text" value="<?php echo($meta['pmb_article_link'][0]); ?>">
		 		<label for="pmb-article-publisher">Publisher:</label>
			 	<input id="pmb-article-publisher" name="pmb-article-publisher" type="text" value="<?php echo($meta['pmb_article_publisher'][0]); ?>">
			 	<label for="pmb-article-publish-date">Publish Date:</label>
			 	<input id="pmb-article-publish-date" name="pmb-article-publish-date" type="text" value="<?php echo($meta['pmb_article_publish_date'][0]); ?>">
			 	<label for="pmb-article-excerpt">Excerpt:</label>
			 	<textarea id="pmb-article-excerpt" name="pmb-article-excerpt" type="text"><?php echo($meta['pmb_article_excerpt'][0]); ?></textarea>
		 	</fieldset> 
		 	<?php
		}

		 /**
		  * Saves the custom Character admin meta fields
		  */
		 public function saveAdminMeta($postId){
			
			// Check if our nonce is set.
			if (!isset( $_POST['article-addl-nonce'] ) )
				return $post_id;
			$nonce = $_POST['article-addl-nonce'];
		
			// Verify that the nonce is valid.
			if (!wp_verify_nonce( $nonce, 'buildAdminMeta'))
				return $post_id;
			
			//Don't do anything if this is an autosave
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return($postId);
			
			//Check the user's permissions
			if ('article' !== $_POST['post_type'] || !current_user_can('edit_page', $postId))
				return($postId);
			
			update_post_meta($postId, 'pmb_article_link', sanitize_text_field($_POST['pmb-article-link']));
			update_post_meta($postId, 'pmb_article_publisher', sanitize_text_field($_POST['pmb-article-publisher']));
			update_post_meta($postId, 'pmb_article_publish_date', sanitize_text_field($_POST['pmb-article-publish-date']));
			update_post_meta($postId, 'pmb_article_excerpt', sanitize_text_field($_POST['pmb-article-excerpt']));
		 }
	}
?>