<?php

	/**
	 * Displays a menu for a nested page
	 */
	class Nested_Menu_Widget extends WP_Widget{
		
		/**
		 * Default c'tor
		 */
		public function __construct(){
			parent::__construct('nested_menu_widget', 'Nested Menu Widget');
		}
		
		/**
		 * Displays the widget's UI elements
		 */
		public function widget($args, $instance){
			
		    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'primary' ] ) ) {
				//Get the current page Id
		    	global $wp_query;
				$parentId = -1;
				$miDict = array();
				$parents = array();
				//Grab all the menu items in the primary navigation menu
				$menu = wp_get_nav_menu_object( $locations[ 'primary' ] );
				$menu_items = wp_get_nav_menu_items($menu->term_id);
				
								
				//Query for the current page id
				$menu = wp_get_nav_menu_items($menu->term_id ,array(
												   'posts_per_page' => -1,
												   'meta_key' => '_menu_item_object_id',
												   'meta_value' => $wp_query->post->ID // the currently displayed post
												));
				//HACK: If two or more matches are returned use the second. The first will be the main menu title
				if (1<count($menu))
					$currPage = intval($menu[1]->ID);
				else
					$currPage = intval($menu[0]->ID);			
				foreach($menu_items as $key => $menuItem){
					$parents[$menuItem->ID] = $menuItem;
					
					//Skip top level menus
					if (!$menuItem->menu_item_parent)
						continue;
					
					$menuItemId = $menuItem->ID;//intval(get_post_meta($menuItem->ID, '_menu_item_object_id', true));
					
					//Store all the sub menus in a temp cache
					if (!array_key_exists($menuItem->menu_item_parent, $miDict))
						$miDict[$menuItem->menu_item_parent] = array();
					array_push($miDict[$menuItem->menu_item_parent], $menuItem);
					
					if ($menuItemId === $currPage){
						$parentId = $menuItem->menu_item_parent;
					}
				}
				if (0<$parentId){
					$this->renderMenu($currPage, $miDict[$parentId], $parents[$parentId], $args);
				}			
			}
		}

		/**
		 * Builds the menu HTML and prints to the response stream
		 */
		private function renderMenu($pageId, $menuItems, $parent, $widgetArgs){
			extract($widgetArgs, EXTR_SKIP);
			//TODO menu name
			$html = $before_widget.$before_title.$parent->title.$after_title.'<ul id="side-menu-' . $menu_name . '" class="side-menu">';
			foreach ($menuItems as $key => $menu_item ) {
			    $title = $menu_item->title;
			    $url = $menu_item->url;
				
			    $html .= '<li'.($menu_item->ID==$pageId ? ' class="current-page-item"' : '').'><a href="' . $url . '">' . $title . '</a></li>';
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
	function registerNestedMenuWidget(){
		register_widget('Nested_Menu_Widget');
	}
	add_action('widgets_init', 'registerNestedMenuWidget')
?>