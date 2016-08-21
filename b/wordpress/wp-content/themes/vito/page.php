<?php get_header(); ?>
  
  <div id="content">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>


        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

            <?php 
            if(!get_post_format()) {
                //Display the Post Image by default
                get_template_part( "post_image", "page" );
            } else {
                get_template_part('format', get_post_format());
            }
            ?>

            <div class="post-inside">
                <?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
    
                <div class="entry">
                    <?php the_content(); ?>
                    <div class="clearfix"></div>
                </div>


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



                </div><!-- /post-inside -->

            <div class="clearfix"></div>

       </article>


       <?php comments_template(); ?>


    <?php endwhile; else: ?>



        <?php get_template_part( "/templates/content-none", "page" ); ?>



    <?php endif; ?>

<?php get_template_part( "/templates/afterloop", "page" ) ?> 

<?php get_footer(); ?>