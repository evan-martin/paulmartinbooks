<?php

	class Character_PostType {
		
		/**
		 * Default c'tor
		 */
		public function __construct(){
			add_action('init', array(&$this, 'createCharacterPostType'));
			add_action('admin_init', array(&$this, 'addCharacterAdminMeta'));
			add_action('save_post', array(&$this, 'saveCharacterAdminMeta'));
			add_filter('manage_character_posts_columns', array(&$this, 'addCharacterColumns'));
			add_filter('manage_character_posts_custom_column', array(&$this, 'populateCharacterColumns'), 10, 2);
		}
		
		/**
		 * Creates and registers the Character post type
		 */
		public function createCharacterPostType(){
			$args = array( 'labels' => array( 'name' => 'Characters',
		 										'singular_name' => 'Character',
		 										'add_new' => __( 'Add New' ),
		            							'add_new_item' => __( 'Add New Character'),
		            							'edit_item' => __( 'Edit Character' )),
							'public' => true,
							'publicly_queryable' => false,
							'menu_position' => 5,
							'has_archive' => true,
							'query_var' => false,
							'exclude_from_search' => true,
							'publicly_queryable' => false,
							'taxonomies' => array('category'),
							'supports' => array('title', 'editor', 'thumbnail'));
							//TODO capabilities
							//TODO supports
							//TODO taxonomies
							//TODO rewrite?
							
		 	register_post_type('character', $args);
		}

		/**
		 * Adds the metabox for custom Character admin fields
		 */
		public function addCharacterAdminMeta(){
		 	add_meta_box('character-additional', 'Additional Information', array(&$this, 'buildCharacterAdminMeta'), 'character', 'side', 'default');
		}
		 
		/**
		 * Creates the HTML for the custom Character admin fields
		 */
		public function buildCharacterAdminMeta($post){
		 	
			//Add an nonce field so we can check for it later.
		  	wp_nonce_field( 'buildCharacterAdminMeta', 'char-addl-nonce' );
			
			//Pull the meta values from the database
		 	$nick = get_post_meta($post->ID, 'pmb_char_nick', true);
		 	?>
		 	<fieldset class="pmb-meta-fields">
			 	<label for="pmb-char-nick">Nickname:</label>
			 	<input id="pmb-char-nick" name="pmb-char-nick" type="text" value="<?php echo($nick); ?>">
		 	</fieldset> 
		 	<?php
		}

		 /**
		  * Saves the custom Character admin meta fields
		  */
		 public function saveCharacterAdminMeta($postId){
			
			// Check if our nonce is set.
			if (!isset( $_POST['char-addl-nonce'] ) )
				return $post_id;
			$nonce = $_POST['char-addl-nonce'];
		
			// Verify that the nonce is valid.
			if (!wp_verify_nonce( $nonce, 'buildCharacterAdminMeta'))
				return $post_id;
			
			//Don't do anything if this is an autosave
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return($postId);
			
			//Check the user's permissions
			if ('character' !== $_POST['post_type'] || !current_user_can('edit_page', $postId))
				return($postId);
			
			update_post_meta($postId, 'pmb_char_nick', sanitize_text_field($_POST['pmb-char-nick']));
		 }

		/**
		 * Adds custom columns to the Characters post table in the admin section
		 */
		public function addCharacterColumns($cols){
			
			$charCols = array();
			//Rename the title column and insert the nickname column into the table
			foreach($cols as $id => $name){
				if ('title' === $id){
					$charCols['title'] = 'Name';
					$charCols['nickname'] = 'Nickname';
				} else {
					$charCols[$id] = $name;
				}
			}
			return($charCols);
		}
	
		/**
		 * Populates the Character custom columns
		 */
		public function populateCharacterColumns($colName, $postId){
			echo($nick = get_post_meta($postId, 'pmb_char_nick', true));
		}
	}
?>