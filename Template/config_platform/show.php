<?php

use Kanboard\Plugin\CRProject\Helper\Factory;

// We are cheating here and use "subtask" functionality (subtasks-table) to drag/drop.
$positionUrl = $this->url->href('ConfigPlatformController', 'position', array('plugin' => 'CRProject'));
$widgetHelper = Factory::widgetHelper();
?>
    <div class="page-header">
        <h2><?= t('Project platform') ?></h2>
    </div>
    <table id="crtable" class="table-list subtasks-table table-striped table-scrolling"
           data-save-position-url="<?= $positionUrl ?>">
        <thead>
        <tr>
            <th><?= t('Title') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($platforms as $platform): ?>
            <tr class="table-list-row <?= 'color-' . $platform['color_id'] ?>" data-subtask-id="<?= $platform['id'] ?>">
                <td style="vertical-align: middle;">
                    <?= $this->render('CRProject:config_platform/menu', array('platform' => $platform)) ?>
                    <?= $widgetHelper->label($platform['color_id'], $platform['title']) ?>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?= $this->modal->medium('plus', t('Add new platform'), 'ConfigPlatformController', 'edit', array(
    'plugin' => 'CRProject',
    'id' => 0
)) ?>