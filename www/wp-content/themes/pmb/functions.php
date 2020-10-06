<?php
		//Include dependencies
		include_once('book_showcase_widget.php');
		/**
		 * Include component level stylesheets
		 */
		function registerPmbStylesheets(){
			
			wp_enqueue_style('home', get_stylesheet_directory_uri().'/css/home.css');	
			wp_enqueue_style('characters', get_stylesheet_directory_uri().'/css/characters.css');
			wp_enqueue_style('articles', get_stylesheet_directory_uri().'/css/articles.css');
			wp_enqueue_style('books', get_stylesheet_directory_uri().'/css/books.css');
			wp_enqueue_style('pmb_media', get_stylesheet_directory_uri().'/css/media.css');
			wp_enqueue_style('contact', get_stylesheet_directory_uri().'/css/contact.css');
			wp_enqueue_style('reviews', get_stylesheet_directory_uri().'/css/reviews.css');
			wp_enqueue_style('sns', get_stylesheet_directory_uri().'/css/sns.css');
		}
		add_action('wp_enqueue_scripts', 'registerPmbStylesheets');
		
		function registerPmbScripts(){
			//Use updated version of jQuery
			wp_deregister_script('jquery');
			wp_register_script('jquery', get_stylesheet_directory_uri().'/js/jquery.js');
			wp_register_script('jquery-migrate', get_stylesheet_directory_uri().'/js/jquery-migrate.js', array('jquery'));
	
			wp_register_script('hover_intent', get_stylesheet_directory_uri().'/js/hoverIntent.js');
			wp_register_script('superfish', get_stylesheet_directory_uri().'/js/superfish.js', array('jquery-migrate', 'hover_intent'));
			wp_enqueue_script('pmb_main', get_stylesheet_directory_uri().'/js/main.js', array('jquery', 'superfish'), false, true);
		}
		add_action('wp_enqueue_scripts', 'registerPmbScripts');
		/** 
		 * Set up the left handed widget
		 */
		function registerPmbSidebars(){
			
			register_sidebar( array( 'name' => 'Left sidebar',
										'id' => 'sidebar-left',
										'before_widget' => '<aside id="%1$s" class="widget %2$s">',
										'after_widget' => '</aside>',
										'before_title' => '<h3 class="widget-title">',
										'after_title' => '</h3>'));
		}
		add_action('widgets_init', 'registerPmbSidebars');
		
		/**
		 * Set up the body classes for the PMB theme
		 */
		function filterPmbBodyClass($classes){
			global $left_sidebar_disabled;
			$classes = twentytwelve_body_class($classes);
			
			if (is_active_sidebar( 'sidebar-left' ) && !$left_sidebar_disabled){
				//Remove the full width class if our custom sidebar is active
				$filtered = array();
				foreach($classes as $class)
				{
					if ('full-width' !== $class)
						array_push($filtered, $class);
				}
				array_push($filtered, 'has-left-sidebar');
				
				return($filtered);
			}
			return($classes);
		}
		add_filter( 'body_class', 'filterPmbBodyClass' );
		
		/**
		 * Filter out 2nd level menu items
		 */
		function filterPrimaryMenu($menuItems){
			
			$cached = array();
			foreach($menuItems as $id => $mi){
				$cached[$mi->ID] = $mi;
			}
			
			$filtered = array();
			foreach($menuItems as $id => $mi){
				
				if (!$mi->menu_item_parent){
					$filtered[$id] = $mi;
				} else {
					
					if (key_exists($mi->menu_item_parent, $cached)){
						 if (!$cached[$mi->menu_item_parent]->menu_item_parent){
							$filtered[$id] = $mi;
						 }
						 else if (is_array($cached[$mi->menu_item_parent]->classes)) {
							 if ($index = array_search('menu-item-has-children', $cached[$mi->menu_item_parent]->classes))
							 unset($index, $cached[$mi->menu_item_parent]->classes);
						 }
					}
				}
			}
			return($filtered);
		}
		add_filter('wp_nav_menu_objects', 'filterPrimaryMenu');
		
		/**
		 * Remove unneeded actions and filters from the parent theme
		 */
		function removeParentHooks( $length ) {
		 	remove_filter( 'body_class', 'twentytwelve_body_class' );
		}
		add_action( 'after_setup_theme', 'removeParentHooks' );
		/**
		 * Disables the admin bar for all users
		 */
		function my_function_admin_bar(){
	    	return (false);
 	 	}
		add_filter('show_admin_bar', 'my_function_admin_bar');
?>