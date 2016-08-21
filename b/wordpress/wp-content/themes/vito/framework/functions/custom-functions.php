<?php
	if ( ! function_exists( '_wp_render_title_tag' ) ) :
		function vito_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
		}
		add_action( 'wp_head', 'vito_render_title' );
	endif;

	//Change the Read More link

	if ( ! function_exists( 'vito_modify_read_more_link' ) ) :
		function vito_modify_read_more_link() {
			return '<a class="more-link btn btn-ql" href="' . esc_url( get_permalink() ) . '">'. esc_html__('Read More', 'vito') . '</a>';
		}
	endif;
	add_filter( 'the_content_more_link', 'vito_modify_read_more_link' );



if ( ! function_exists( 'the_post_navigation' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function the_post_navigation() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'vito' ); ?></h2>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', '%title' );
				next_post_link( '<div class="nav-next">%link</div>', '%title' );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

?>