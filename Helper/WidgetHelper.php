<?php

namespace Kanboard\Plugin\CRProject\Helper;

use Kanboard\Core\Base;

class WidgetHelper extends Base
{
    /**
     * Label.
     *
     * @param $colorId
     * @param $text
     * @param array $styles
     * @return string
     * @throws \Exception
     */
    public function label($colorId, $text, $styles = array())
    {
        $colorHelper = Factory::colorHelper();
        $prepareStyles = [
            'display: inline',
            'position: relative',
            'border-radius: 6px',
            'padding: 2px 5px 2px 5px',
            'background-color: ' . $colorHelper->background($colorId),
            'border: 1px solid ' . $colorHelper->border($colorId)
        ];

        if (count($styles) > 0) {
            $prepareStyles = array_merge($prepareStyles, $styles);
        }

        $output = [];
        $output[] = '<div';
        $output[] = ' style="' . implode('; ', $prepareStyles) . '"';
        $output[] = '>';
        $output[] = $text;
        $output[] = '</div>';
        return implode('', $output);
    }
}