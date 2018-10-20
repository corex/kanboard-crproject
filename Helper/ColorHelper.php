<?php

namespace Kanboard\Plugin\CRProject\Helper;

use Kanboard\Core\Base;

class ColorHelper extends Base
{
    /**
     * Name.
     *
     * @param string $colorId
     * @return string
     */
    public function name($colorId)
    {
        $properties = $this->properties($colorId);
        return $properties['name'];
    }

    /**
     * Background.
     *
     * @param string $colorId
     * @return string
     */
    public function background($colorId)
    {
        $properties = $this->properties($colorId);
        return $properties['background'];
    }

    /**
     * Border.
     *
     * @param string $colorId
     * @return string
     */
    public function border($colorId)
    {
        $properties = $this->properties($colorId);
        return $properties['border'];
    }

    /**
     * Properties.
     *
     * @param string $colorId
     * @return array
     */
    private function properties($colorId)
    {
        return $this->colorModel->getColorProperties($colorId);
    }
}