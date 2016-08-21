<?php
/**
 * The template used for displaying individual post pages
 *
 * @package Libretto
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<?php the_content(); ?>
		
	<script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
<script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script>
<div class="ya-share2" data-services="vkontakte,facebook,gplus,twitter,linkedin,lj,tumblr,viber,whatsapp" data-counter=""></div>

		<?php wp_link_pages( array(
			'before'   => '<div class="page-links">'.__( 'Pages:', 'libretto' ),
			'pagelink' => '<span>%</span>',
			'after'    => '</div>',
		) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php libretto_entry_footer(); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
