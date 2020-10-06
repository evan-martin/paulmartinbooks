<?php
/**
 * Plugin Name: Paul Martin Books
 * Description: WordPress plug-in enabling functionaly for www.paulmartinbooks.com
 * Version: 0.1
 * Author: Andrew Scanlon
 * Author URI: http://www.boundingdog.com
 */
include_once('nested-menu-widget.php');
include_once('pmb_shortcodes.php');

//Init custom post types
include_once('pmb-character-post-type.php');
$charPT = new Character_PostType();
include_once('pmb-book-post-type.php');
$bookPT = new Book_PostType();
include_once('pmb-article-post-type.php');
$articlePT = new Article_PostType();
include_once('pmb-book-media-post-type.php');
$bookMediaPT = new BookMedia_PostType();
include_once('pmb-review-post-type.php');
$bookMediaPT = new Review_PostType();
include_once('pmb-standout-stinker-post-type.php');
$bookMediaPT = new StandoutStinker_PostType();

/**
 * Enqueue custom admin stylesheet
 */
function registerPmbAdminCss(){
 	wp_enqueue_style('pmb_admin_css', plugins_url('admin/css/admin-styles.css', __FILE__));
 }
 add_action('admin_init', 'registerPmbAdminCss');
 

function addCustomFieldsToPageDefs()
{
    if ( ! isset ( $GLOBALS['post'] ) )
        return;

    $post_type = get_post_type( $GLOBALS['post'] );

    if ( ! post_type_supports( $post_type, 'custom-fields' ) )
        return;
    ?>
<script>
    if ( jQuery( "[value='pmb_book']" ).length < 1 ) // avoid duplication
        jQuery( "#metakeyselect").append( "<option value='pmb_book'>pmb_book</option>" );
</script>
    <?php
}
add_action( 'admin_footer-post-new.php', 'addCustomFieldsToPageDefs' );
add_action( 'admin_footer-post.php', 'addCustomFieldsToPageDefs' ); 
?>