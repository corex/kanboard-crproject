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
            'padding: 2px 5px 2px 5px',
            'background-color: ' . $colorHelper->background($colorId),
            'border-color: ' . $colorHelper->border($colorId)
        ];

        if (count($styles) > 0) {
            $prepareStyles = array_merge($prepareStyles, $styles);
        }

        $output = [];
        $output[] = '<div class="task-board task-board-status-open"';
        $output[] = ' style="' . implode('; ', $prepareStyles) . '"';
        $output[] = '>';
        $output[] = $text;
        $output[] = '</div>';
        return implode('', $output);
    }
}