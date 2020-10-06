<?php

	/**
	 * Displays a menu for a nested page
	 */
	class BookShowcase_Widget extends WP_Widget{
		
		/**
		 * Default c'tor
		 */
		public function __construct(){
			parent::__construct('book_showcase_widget', 'Book Showcase Widget');
		}
		
		/**
		 * Displays the widget's UI elements
		 */
		public function widget($args, $instance){
			
			echo('foo');
			return;
			
		    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'primary' ] ) ) {
				//Get the current page Id
		    	global $wp_query;
		    	$currPageName = $wp_query->post->post_name;
				$currPage = intval($this->getPageBySlug($currPageName)->ID);
				
				$parentId = -1;
				$miDict = array();
				$parents = array();
				//Grab all the menu items in the primary navigation menu
				$menu = wp_get_nav_menu_object( $locations[ 'primary' ] );
				$menu_items = wp_get_nav_menu_items($menu->term_id);
				foreach($menu_items as $key => $menuItem){
					
					$parents[$menuItem->ID] = $menuItem;
					
					//Skip top level menus
					if (!$menuItem->menu_item_parent)
						continue;
					
					$menuItemId = intval(get_post_meta($menuItem->ID, '_menu_item_object_id', true));
					
					//Store all the sub menus in a temp cache
					if (!array_key_exists($menuItem->menu_item_parent, $miDict))
						$miDict[$menuItem->menu_item_parent] = array();
					array_push($miDict[$menuItem->menu_item_parent], $menuItem);
					
					if ($menuItemId === $currPage){
						$parentId = $menuItem->menu_item_parent;
					}
				}
				if (0<$parentId){
					$this->renderMenu($miDict[$parentId], $parents[$parentId], $args);
				}			
			}
		}

		/**
		 * Builds the menu HTML and prints to the response stream
		 */
		private function renderMenu($menuItems, $parent, $widgetArgs){
			extract($widgetArgs, EXTR_SKIP);
			//echo(json_encode($parent));
			//TODO menu name
			$html = $before_widget.$before_title.$parent->title.$after_title.'<ul id="side-menu-' . $menu_name . '" class="side-menu">';
			foreach ($menuItems as $key => $menu_item ) {
			    $title = $menu_item->title;
			    $url = $menu_item->url;
			    $html .= '<li><a href="' . $url . '">' . $title . ($menu_item->object_id===$pageId ? ' [current]' : '').'</a></li>';
			}
			$html .= '</ul>'.$after_wdiget;
			
			echo $html;
		}
		
		/**
		 * Retrieves the page using the supplied slug
		 */
		private function getPageBySlug($slug){
			global $wpdb;
			$page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type='page'", $slug) );
			if ( $page )
				return get_post( $page, null );
		
			return null;			
		}
	}
	
	//Register the widget
	function registerBookShowcaseWidget(){
		register_widget('BookShowcase_Widget');
	}
	add_action('widgets_init', 'registerBookShowcaseWidget')
?>