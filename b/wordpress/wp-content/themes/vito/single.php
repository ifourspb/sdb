<?php get_header(); ?>

    <div id="content">
                
    	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
        	

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >


                <?php get_template_part( "post_image", "single" ); ?>

                <div class="post-inside container-fluid">
                    <div class="row">
                        <div class="post-content col-md-9 col-lg-10">
                            <?php the_title( '<h1 class="post_title">', '</h1>' ); ?>

                            <div class="entry">
                        
                                <?php the_content(); //Read more button is in framework/functions/single_functions.php?>

                                <?php if(get_the_tags()){ ?>
                                <p class="tags"><i class="fa fa-tag"></i> <?php the_tags('', '', ''); ?></p>
                                <?php } ?>

                                <div class="clearfix"></div>
                            </div><!-- /entry -->
                            <?php
                            wp_link_pages( array(
                                'before'      => '<div class="page-links">',
                                'after'       => '</div>',
                                'link_before' => '<span>',
                                'link_after'  => '</span>',
                                'pagelink'    => esc_attr__( 'Page', 'vito' ) . ' %',
                                'separator'   => '',
                            ) );
                            ?>

                            <div class="clearfix"></div>
                        </div><!-- /post_content -->


                        <div class="metadata col-md-3 col-lg-2">
                            <?php get_template_part( "meta", "single" ); ?>
                            <div class="clearfix"></div>
                        </div><!-- /metadata -->

                        </div><!-- /row -->
                    </div><!-- /post-inside -->

                <div class="clearfix"></div>
            </article>

                    
            <div class="clearfix"></div>
                    
        			
            <?php comments_template(); ?>

            <?php the_post_navigation(); ?>

    
<?php endwhile; else: ?>
        
    
        <?php get_template_part( "/templates/content-none", "single" ); ?>
    
        
<?php endif; ?>
            
    <?php get_template_part( "/templates/afterloop", "single" ) ?> 

<?php get_footer(); ?>