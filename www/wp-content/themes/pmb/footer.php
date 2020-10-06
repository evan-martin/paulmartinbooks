<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div> <!-- inside #main.wrapper -->
	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
		<div class="copyright">
			<p>Copyright © 2012-<?php echo(date('Y')); ?> by <span class="strong">Paul Martin</span>. All rights reserved.</p>
			<p>Site design by <a id="bd-link" href="http://www.boundingdog.com" target="_blank">boundingdog</a></p>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>