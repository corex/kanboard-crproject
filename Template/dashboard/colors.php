<?php
$widgetHelper = \Kanboard\Plugin\CRProject\Helper\Factory::widgetHelper();
$request = \Kanboard\Plugin\CRProject\Helper\Factory::request();
?>
<?php if ($request->getStringParam('controller') == 'BoardViewController' && count($colors) > 0): ?>
    <div style="padding: 15px 5px 10px 0px;">
        <?= t('Task colors') ?>:
        <?php
        foreach ($colors as $colorId => $title) {
            print($widgetHelper->label($colorId, $title) . ' ');
        }
        ?>
    </div>
<?php endif; ?>