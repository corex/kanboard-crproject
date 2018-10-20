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
     * @return string
     * @throws \Exception
     */
    public function label($colorId, $text)
    {
        $colorHelper = Factory::colorHelper();
        $styles = [
            'display: inline',
            'position: relative',
            'border-radius: 6px',
            'padding: 2px 5px 2px 5px',
            'background-color: ' . $colorHelper->background($colorId),
            'border: 1px solid ' . $colorHelper->border($colorId)
        ];
        $output = [];
        $output[] = '<div';
        $output[] = ' style="' . implode('; ', $styles) . '"';
        $output[] = '>';
        $output[] = $text;
        $output[] = '</div>';
        return implode('', $output);
    }
}