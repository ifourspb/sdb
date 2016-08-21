<?php
/**
 * @var $this   N2View
 * @var $_class N2SmartsliderBackendSlidersView
 */

$this->widget->init('topbar', array());
?>
    <div class="n2-ss-dashboard">
        <div class="n2-box n2-box-border n2-box-huge n2-ss-create-slider">
            <img src="<?php echo N2ImageHelper::fixed('$ss$/admin/images/create-slider.png') ?>">

            <div class="n2-box-placeholder">
                <table>
                    <tbody>
                    <tr>
                        <td class="n2-box-button">
                            <div class="n2-h2"><?php n2_e('It\'s a great day to start something new.'); ?></div>

                            <div
                                class="n2-h3"><?php n2_e('Click on the \'Create Slider\' button to get started.'); ?></div>
                            <a href="#"
                               class="n2-button n2-button-x-big n2-button-green n2-uc n2-h3 n2-ss-create-slider"><?php n2_e('Create slider'); ?></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php

        function n2GetBox($class, $image, $html, $hasBorder = true) {
            echo NHtml::tag('div', array(
                'class' => 'n2-box n2-box-title ' . $class . ($hasBorder ? ' n2-box-border' : '')
            ), NHtml::image(N2ImageHelper::fixed('$ss$/admin/images/' . $image)) . NHtml::tag("div", array(
                    'class' => 'n2-box-placeholder'
                ), NHtml::tag("table", array(), NHtml::tag("tr", array(), NHtml::tag("td", array(
                    'class' => 'n2-box-button'
                ), $html)))));
        }

        n2GetBox('n2-ss-demo-slider', 'add-demo.png', '<div>' . n2_('100+ Sample slide with one click.') . '</div><a href="#" class="n2-button n2-button-small n2-button-green n2-uc n2-h5">' . n2_('add sample slider') . '</a>');

        ob_start();
        $this->widget->init("buttonmenu", array(
            "content" => NHtml::tag('div', array(
                'class' => 'n2-button-menu'
            ), NHtml::tag('div', array(
                'class' => 'n2-button-menu-inner n2-border-radius'
            ), NHtml::link(n2_('Import by upload'), $this->appType->router->createUrl(array('sliders/importbyupload')), array(
                    'class' => 'n2-h4'
                )) . NHtml::link(n2_('Import from server'), $this->appType->router->createUrl(array('sliders/importfromserver')), array(
                    'class' => 'n2-h4'
                )) . NHtml::link(n2_('Export all slider'), $this->appType->router->createUrl(array('sliders/exportall')), array(
                    'class'  => 'n2-h4',
                    'target' => '_blank'
                ))))
        ));

        n2GetBox('', 'import-upload.png', '<div>' . n2_('Import slider from different sources.') . '</div>' . NHtml::tag('div', array('class' => 'n2-button n2-button-with-menu n2-button-small n2-button-green'), NHtml::link(n2_('Import by upload'), $this->appType->router->createUrl(array('sliders/importbyupload')), array(
                    'class' => 'n2-button-inner n2-uc n2-h5'
                )) . ob_get_clean()));

        n2GetBox('n2-box-wide n2-box-overflow n2-box-free', 'free/box2.png', NHtml::tag('div', array(), 'Take your slider to the next level with Smart Slider 3 PRO!') . NHtml::link('See all features', N2SS3::getWhyProUrl(), array(
                'target' => '_blank',
                'class'  => 'n2-button n2-button-blue n2-button-medium n2-h5 n2-uc'
            )), false);
    

        n2GetBox('', 'Documentation.png', NHtml::tag('div', array(), 'Interactive online documentation.') . NHtml::link('Read', 'http://doc.smartslider3.com', array(
                'target' => '_blank',
                'class'  => 'n2-button n2-button-grey n2-button-small n2-h5 n2-uc'
            )));
        n2GetBox('', 'Videos.png', NHtml::tag('div', array(), 'Helpful tutorial videos.') . NHtml::link('Watch', 'https://www.youtube.com/watch?v=MKmIwHAFjSU&list=PLSawiBnEUNfvzcI3pBHs4iKcbtMCQU0dB', array(
                'target' => '_blank',
                'class'  => 'n2-button n2-button-grey n2-button-small n2-h5 n2-uc'
            )));
        n2GetBox('', 'Help.png', NHtml::tag('div', array(), 'First class support with real people. ') . NHtml::link('Write', 'http://smartslider3.com/contact-us/', array(
                'target' => '_blank',
                'class'  => 'n2-button n2-button-grey n2-button-small n2-h5 n2-uc'
            )));
        n2GetBox('', 'Newsletter.png', NHtml::tag('div', array(), 'Receive the latest news.') . NHtml::link('Subscribe', 'http://eepurl.com/bDp_8b', array(
                'target' => '_blank',
                'class'  => 'n2-button n2-button-grey n2-button-small n2-h5 n2-uc'
            )));

        n2GetBox('', 'Facebook.png', NHtml::tag('div', array(), 'Join the community on Facebook.') . NHtml::link('Join', 'https://www.facebook.com/nextendweb', array(
                'class'  => 'n2-button n2-button-grey n2-button-small n2-h5 n2-uc',
                'target' => '_blank'
            )));
        n2GetBox('', 'Love.png', NHtml::tag('div', array(), 'Are you satisfied with Smart Slider 3?') . NHtml::link('Yes', 'http://smartslider3.com/satisfied-customer/', array(
                'target' => '_blank',
                'class'  => 'n2-button n2-button-green n2-button-small n2-h5 n2-uc'
            )) . NHtml::link('No', 'http://smartslider3.com/suggestion/', array(
                'target' => '_blank',
                'class'  => 'n2-button n2-button-red n2-button-small n2-h5 n2-uc'
            )));

        ?>

        <div class="n2-clear"></div>
    </div>
<?php N2SS3::showBeacon('Main page, Import, Update'); ?>