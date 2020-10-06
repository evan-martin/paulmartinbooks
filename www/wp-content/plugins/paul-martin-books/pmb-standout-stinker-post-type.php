<?php

	class StandoutStinker_PostType {
		
		/**
		 * Default c'tor
		 */
		public function __construct(){
			add_action('init', array(&$this, 'createPostType'));
			add_action('admin_init', array(&$this, 'addAdminMeta'));
			add_action('save_post', array(&$this, 'saveAdminMeta'));
			add_filter('manage_sns_posts_columns', array(&$this, 'addTableColumns'));
			add_filter('manage_sns_posts_custom_column', array(&$this, 'populateTableColumns'), 10, 2);
		}
		
		/**
		 * Creates and registers the Character post type
		 */
		public function createPostType(){
						
			$args = array( 'labels' => array( 'name' => 'Standouts & Stinkers',
		 										'singular_name' => 'Standout/Stinker',
		 										'add_new' => __( 'Add New' ),
		            							'add_new_item' => __( 'Add New'),
		            							'edit_item' => __( 'Edit' )),
							'public' => true,
							'publicly_queryable' => false,
							'menu_position' => 5,
							'has_archive' => true,
							'query_var' => false,
							'exclude_from_search' => true,
							'publicly_queryable' => false,
							'supports' => array('title', 'editor'));
							//TODO capabilities
							//TODO supports
							//TODO taxonomies
							//TODO rewrite?
							
		 	register_post_type('sns_pt', $args);
		}

		/**
		 * Adds the metabox for custom Character admin fields
		 */
		public function addAdminMeta(){
		 	//add_meta_box('standout-stinker-additional', 'Profile Details', array(&$this, 'buildStandoutStinkerAdminMeta'), 'sns', 'normal', 'high');
		}
		 
		/**
		 * Creates the HTML for the custom Character admin fields
		 */
		public function buildStandoutStinkerAdminMeta($post){
		 	
			//Add an nonce field so we can check for it later.
		  	wp_nonce_field( 'buildAdminMeta', 'standout-stinker-addl-nonce' );
			
			//Pull the meta values from the database
			$meta = get_post_meta($post->ID);
			$rating = 'c1';
			if ($meta['pmb_sns_cheers_jeers'][0])
				$rating = $meta['pmb_sns_cheers_jeers'][0];
		 	?>
		 	<fieldset class="pmb-meta-fields pmb-meta-books">
		 		<label for="pmb-sns-name">Name:</label>
			 	<input id="pmb-sns-name" name="pmb-sns-name" type="text" value="<?php echo($meta['pmb_sns_name'][0]); ?>">
			 	<label for="pmb-sns-cheers-jeers">Rating:</label>
			 	<div class="radio-group">
				 	<input type="radio" id="pmb-cheers-1" name="pmb-cheers-jeers" value="c1" <?php echo('c1' === $rating ? 'checked' : ''); ?>><label for="pmb-cheers-1">1 Cheer</label>
				 	<input type="radio" id="pmb-cheers-2" name="pmb-cheers-jeers" value="c2" <?php echo('c2' === $rating ? 'checked' : ''); ?>><label for="pmb-cheers-2">2 Cheers</label>
				 	<input type="radio" id="pmb-cheers-3" name="pmb-cheers-jeers" value="c3" <?php echo('c3' === $rating ? 'checked' : ''); ?>><label for="pmb-cheers-3">3 Cheers</label>
				 	<div class="vert-sep"></div>
				 	<input type="radio" id="pmb-jeers-3" name="pmb-cheers-jeers" value="j3" <?php echo('j3' === $rating ? 'checked' : ''); ?>><label for="pmb-jeers-3">3 Jeers</label>
				 	<input type="radio" id="pmb-jeers-2" name="pmb-cheers-jeers" value="j2" <?php echo('j2' === $rating ? 'checked' : ''); ?>><label for="pmb-jeers-2">2 Jeers</label>
				 	<input type="radio" id="pmb-jeers-1" name="pmb-cheers-jeers" value="j1" <?php echo('j1' === $rating ? 'checked' : ''); ?>><label for="pmb-jeers-1">1 Jeer</label>
			 	</div>
		 	</fieldset> 
		 	<?php
		}

		 /**
		  * Saves the custom Character admin meta fields
		  */
		 public function saveAdminMeta($postId){
			
			// Check if our nonce is set.
			if (!isset( $_POST['standout-stinker-addl-nonce'] ) )
				return $post_id;
			$nonce = $_POST['standout-stinker-addl-nonce'];
		
			// Verify that the nonce is valid.
			if (!wp_verify_nonce( $nonce, 'buildAdminMeta'))
				return $post_id;
			
			//Don't do anything if this is an autosave
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return($postId);
			
			//Check the user's permissions
			if ('sns' !== $_POST['post_type'] || !current_user_can('edit_page', $postId))
				return($postId);
			
			update_post_meta($postId, 'pmb_sns_name', sanitize_text_field($_POST['pmb-sns-name']));
			update_post_meta($postId, 'pmb_sns_cheers_jeers', sanitize_text_field($_POST['pmb-cheers-jeers']));
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
					//$bookCols['name'] = 'Name';
					//$bookCols['rating'] = 'Rating';
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
			if ('name' === $colName){
				echo(get_post_meta($postId, 'pmb_sns_name', true));
			}
			else if ('rating' === $colName){
				$rating = get_post_meta($postId, 'pmb_sns_cheers_jeers', true);
				$rank = intval($rating[1]);
				
				echo($rank.' '.('c'===$rating[0] ? 'Cheer' : 'Jeer').(1<$rank ? 's' :''));
			}
		}
	}
?>