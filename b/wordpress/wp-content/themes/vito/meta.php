<div class="metadata">
	<ul>
		<li class="meta_date"><time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_time('F j, Y'); ?></a></time></li>
		<li class="meta_comments"><?php comments_popup_link(esc_attr__('No Comments', 'vito'), esc_attr__('1 Comment', 'vito'), esc_attr__('% Comments', 'vito')); ?></li>
        <li class="meta_author"><?php the_author() ?></li>
        <li class="meta_category"><?php the_category(', ') ?></li>
        
    </ul>
    <div class="clearfix"></div>
</div><!-- /metadata -->
			            	
			            		