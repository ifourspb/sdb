<?php get_header(); ?>

    <div id="content">

    <?php
        the_archive_title( '<h1 class="page-title">', '</h1>' );
        the_archive_description( '<div class="taxonomy-description">', '</div>' );
    ?>


    <?php if (have_posts()) : ?>


        <?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

                <?php 
                if(!get_post_format()) {
                    //Display the Post Image by default
                    get_template_part( "post_image", "archive" );
                } else {
                    get_template_part('format', get_post_format());
                }
                ?>

                <div class="post-inside container-fluid">
                    <div class="row">
                        <div class="post-content col-md-9 col-lg-10">
                            <?php the_title( sprintf( '<h2 class="post_title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

                            <div class="entry">
                                <?php the_content(); //Read more button is in framework/functions/single_functions.php?>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div><!-- /post_content -->

                        <div class="metadata col-md-3 col-lg-2">
                            <?php get_template_part( "meta", "index" ); ?>
                             <div class="clearfix"></div>
                        </div><!-- /metadata -->

                    </div><!-- /row -->
                </div><!-- /post-inside -->

                <div class="clearfix"></div>
            </article>



            <?php endwhile; ?>

            <?php get_template_part( "pagination", "index" ); ?>

    <?php else : ?>

        
            <?php get_template_part( "/templates/content-none", "archive" ); ?>
       

    <?php endif; ?>


    <?php get_template_part( "/templates/afterloop", "archive" ) ?> 

    <?php get_footer(); ?>
