<?php get_header(); ?>

	<div id="content">

        <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'vito' ), get_search_query() ); ?></h1>

			<?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

                        <?php 
                        if(!get_post_format()) {
                            //Display the Post Image by default
                            get_template_part( "post_image", "search" );
                        } else {
                            get_template_part('format', get_post_format());
                        }
                        ?>

                        <div class="post-inside container-fluid">
                            <div class="row">
                                <div class="post-content col-md-9 col-lg-10">
                                    <?php the_title( sprintf( '<h2 class="post_title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

                                    <div class="entry">
                                       <?php the_excerpt(); ?>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div><!-- /post_content -->

                                <div class="metadata col-md-3 col-lg-2">
                                    <?php get_template_part( "meta", "search" ); ?>
                                     <div class="clearfix"></div>
                                </div><!-- /metadata -->

                            </div><!-- /row -->
                        </div><!-- /post-inside -->

                        <div class="clearfix"></div>
                    </article>
        
                <?php endwhile; ?>
        

                    <?php get_template_part( "pagination", "search" ); ?>

        
                <?php else : ?>

                    <?php get_template_part( "/templates/content-none", "search" ); ?>
        
                <?php endif; ?>
                    
              <?php get_template_part( "/templates/afterloop", "search" ) ?> 

<?php get_footer(); ?>