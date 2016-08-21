	<?php get_header(); ?>
		<div id="content">
                        
             <article class="error-404 not-found">
                <div class="post-inside">
                        
                        <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'vito' ); ?></h1>
                        
                        <p><?php esc_html_e( 'It looks like nothing was found at this location.', 'vito' ); ?></p>
                        
                    <div class="clearfix"></div>
                </div>
                            
             </article>
        <?php get_template_part( "/templates/afterloop", "404" ) ?> 
	
	<?php get_footer(); ?>