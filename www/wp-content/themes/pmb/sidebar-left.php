<?php
if ( ! is_active_sidebar( 'sidebar-left' ) )
	return;
// If we get this far, we have widgets. Let do this.
?>
<div id="left-sidebar" class="widget-area" role="complementary">
	<div class="first front-widgets">
		<?php dynamic_sidebar( 'sidebar-left' ); ?>
	</div>
</div>