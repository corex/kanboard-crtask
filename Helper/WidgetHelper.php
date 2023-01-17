<?php

namespace Kanboard\Plugin\CRTask\Helper;

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
            'padding: 2px 5px 2px 5px'
        ];
        if ($colorId !== null) {
            $styles[] = 'background-color: ' . $colorHelper->background($colorId);
            $styles[] = 'border-color: ' . $colorHelper->border($colorId);
        }
        $output = [];
        $output[] = '<div class="task-board task-board-status-open"';
        $output[] = ' style="' . implode('; ', $styles) . '"';
        $output[] = '>';
        $output[] = $text;
        $output[] = '</div>';
        return implode('', $output);
    }
}