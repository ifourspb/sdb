<?php
N2Loader::import('libraries.form.element.radiotab');

class N2ElementVAlign extends N2ElementRadioTab
{

    protected $class = 'n2-form-element-radio-tab n2-form-element-icon-radio';

    function generateOptions(&$xml) {
        $options = array(
            'top'    => 'n2-i n2-it n2-i-vertical-top',
            'middle' => 'n2-i n2-it n2-i-vertical-middle',
            'bottom' => 'n2-i n2-it n2-i-vertical-bottom'
        );
        $length  = count($options) - 1;

        $this->values = array();
        $html         = '';
        $i            = 0;
        foreach ($options AS $value => $class) {
            $this->values[] = $value;

            $html .= NHtml::tag('div', array(
                'class' => 'n2-radio-option' . ($this->isSelected($value) ? ' n2-active' : '') . ($i == 0 ? ' n2-first' : '') . ($i == $length ? ' n2-last' : '')
            ), NHtml::tag('i', array('class' => $class)));
            $i++;
        }
        return $html;
    }
}