<div class="n2-table n2-table-fixed n2-ss-slider-publish">
    <div class="n2-tr">
        <div class="n2-td n2-first">
            <div class="n2-h2"><?php n2_e('Shortcode'); ?></div>

            <div class="n2-h4"><?php n2_e('Copy and paste this shortcode into your posts:'); ?></div>
            <code><div onclick="return selectText(this);">[smartslider3 slider=<?php echo $sliderid; ?>]</div></code>
        </div>
        <div class="n2-td">
            <div class="n2-h2"><?php n2_e('Page or Post editor'); ?></div>

            <div class="n2-h4"><?php n2_e('Insert it into an existing post with the icon:'); ?></div>
            <img
                src="<?php echo N2ImageHelper::fixed('$ss$/admin/images/wordpress-publish.png') ?>"/>
        </div>
        <div class="n2-td n2-last">
            <div class="n2-h2"><?php n2_e('PHP code'); ?></div>

            <div class="n2-h4"><?php n2_e('Paste the PHP code into your template file:'); ?></div>
            <code><div onclick="return selectText(this);">
                    &lt;?php <br />
                    echo do_shortcode('[smartslider3 slider=<?php echo $sliderid; ?>]');<br />
                    ?&gt;</div></code>
        </div>
    </div>
</div>