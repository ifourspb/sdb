<?php
/**
 * The template for displaying the footer.
 *
 * @package Libretto
 */
?>

		<footer id="colophon" class="site-footer" role="contentinfo">

			

			<?php
			// Prepare social media nav
			if ( has_nav_menu( 'social' ) ) : ?>
				<div id="social">
					<?php wp_nav_menu( array(
						'theme_location' => 'social',
					 	'link_before'    => '<span class="screen-reader-text">',
						'link_after'     => '</span>',
					 	'fallback_cb'    => false,
					 	'depth'          => 1,
					) );
				 	?>
				</div><!-- #social -->
			<?php endif; ?>

		</footer><!-- #colophon -->

		<?php wp_footer(); ?>

		<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-70311241-1', 'auto');
  ga('send', 'pageview');

</script>

	</body>
</html>
