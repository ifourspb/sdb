<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section
 *
 * @package Libretto
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

		
		<?php if ( ! is_attachment() ) : // Don't show header for attachments ?>

			<header id="masthead" class="site-header" role="banner"

			<?php
			/*
			 * If we have a custom image set, we're going to do some manipulation to the masthead height via JS,
			 * This means that we need to pass the height of the image is being shown as a data-attribute.
			 * This way, JS will know our image height without resorting to anything complicated.
			 */
			$libretto_header_image_height = libretto_get_header_image( 'height' );
			if ( isset( $libretto_header_image_height ) ) :
				echo 'data-image-height="'. absint( $libretto_header_image_height ) . '"';
			endif;
			?>

			>

				<!-- PAGE HEADER -->
				<div class="title-block">

				<?php if ( is_home() ) : // Show the site title & tagline ?>
					<?php if ( function_exists( 'jetpack_the_site_logo' ) ) :
						jetpack_the_site_logo();
					endif; ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" style="text-decoration: underline;"><?php bloginfo( 'name' ); ?></a></h1>
					<p class="top_menu"><a href="/about/" style="text-decoration: underline;">Обо мне</a></p>
					<a href="http://vorobushek.com" target="_blank"><img src="/wp-content/uploads/2016/01/log224.png" alt="Фотостудия Воробушек" title="Фотостудия Воробушек" /></a>
				<?php elseif ( is_single() ) : // Show the post title and metadata for posts ?>
						<?php if ( function_exists( 'jetpack_the_site_logo' ) ) :
						jetpack_the_site_logo();
					endif; ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<p class="top_menu"><a href="/about/" style="text-decoration: underline;">Обо мне</a></p>
					<a href="http://vorobushek.com" target="_blank"><img src="/wp-content/uploads/2016/01/log224.png" alt="Фотостудия Воробушек" title="Фотостудия Воробушек" /></a>
					<h1><?php the_title(); ?></h1>

				<?php elseif ( is_page() ) : // Show the page title for pages ?>
					<?php if ( function_exists( 'jetpack_the_site_logo' ) ) :
						jetpack_the_site_logo();
					endif; ?>
					<h1 class="site-title"><a style="text-decoration: underline;" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<p class="top_menu"><a style="text-decoration: underline;" href="/about/">Обо мне</a></p>
					<a href="http://vorobushek.com" target="_blank"><img src="/wp-content/uploads/2016/01/log224.png" alt="Фотостудия Воробушек" title="Фотостудия Воробушек" /></a>
					<h1><?php the_title(); ?></h1>

				<?php elseif ( is_archive() ) : // Show archive title
					the_archive_title( '<h1>', '</h1>' );
					the_archive_description( '<h3>', '</h3>' );
				?>

				<?php elseif ( is_404() ) : // Show "page not found" ?>
					<h1><?php esc_html_e( 'Error', 'libretto' ); ?></h1>
					<h3><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'libretto' ); ?></h3>

				<?php elseif ( is_search() ) : // Search results ?>
					<h1><?php esc_html_e( 'Search results', 'libretto' ); ?></h1>
					<h3><?php printf( esc_html__( 'You searched for %s', 'libretto' ), '<span>' . get_search_query() . '</span>' ); ?></h3>

				<?php endif; ?>

				</div><!-- .title-block -->
			</header><!-- #masthead -->
		<?php endif; ?>
