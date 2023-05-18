<?php

use Kanboard\Plugin\CRTask\Helper\Factory;

$widgetHelper = Factory::widgetHelper();
$request = Factory::request();
?>
<?php if (in_array($request->controller(), ['BoardViewController']) && count($colors) > 0): ?>
    <div style="position: relative; padding: 15px 5px 10px 0px; display:inline; white-space: nowrap;">
        <?= t('Task colors') ?>:
        <?php

        $urlTemplate = '<a href="#" class="filter-helper" data-filter="status:open">{title}</a>';
        $title = str_replace('{title}', t('Reset'), $urlTemplate);
        print($widgetHelper->label(null, $title) . ' ');

        foreach ($colors as $colorId => $title) {

            // Build url for filter.
            $urlTemplate = '<a href="#" class="filter-helper" data-filter="status:open color:{colorId}">{title}</a>';
            $title = str_replace('{title}', $title, $urlTemplate);
            $title = str_replace('{colorId}', $colorId, $title);

            print($widgetHelper->label($colorId, $title) . ' ');
        }
        ?>
    </div>
<?php endif; ?>
