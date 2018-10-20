<?php

use Kanboard\Plugin\CRProject\Helper\Factory;

$widgetHelper = Factory::widgetHelper();
$request = Factory::request();
?>
<?php if (in_array($request->controller(), ['BoardViewController']) && count($colors) > 0): ?>
    <div style="padding: 15px 5px 10px 0px;">
        <?= t('Task colors') ?>:
        <?php
        foreach ($colors as $colorId => $title) {
            print($widgetHelper->label($colorId, $title) . ' ');
        }
        ?>
    </div>
<?php endif; ?>