<?php
if ( has_post_thumbnail() ) {
?>
<div class="post-image">
	<a href="<?php echo esc_url(get_permalink()) ?>" class="ql_thumbnail_hover" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
		<span><i class="fa fa-chevron-right"></i></span>

		<?php the_post_thumbnail('post'); ?>

	</a>
</div><!-- /post_image -->
<?php
}
?>