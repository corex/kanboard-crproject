<?php

use Kanboard\Plugin\CRProject\Helper\Factory;

// We are cheating here and use "subtask" functionality (subtasks-table) to drag/drop.
$positionUrl = $this->url->href('ConfigTaskColorController', 'position', array('plugin' => 'CRProject'));
$widgetHelper = Factory::widgetHelper();
?>
<div class="page-header">
    <h2><?= t('Project task color') ?></h2>
</div>
<table id="crtable" class="table-list subtasks-table table-striped table-scrolling"
       data-save-position-url="<?= $positionUrl ?>">
    <thead>
    <tr>
        <th><?= t('Title') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($colors as $color): ?>
        <tr class="table-list-row <?= 'color-' . $color['color_id'] ?>" data-subtask-id="<?= $color['id'] ?>">
            <td style="vertical-align: middle;">
                <i class="fa fa-arrows-alt draggable-row-handle" title="<?= t('Change position') ?>"></i>&nbsp;
                <?= $this->render('CRProject:config_task_color/menu', array('color' => $color)) ?>
                <?= $widgetHelper->label($color['color_id'], $color['title']) ?>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
<?= $this->modal->medium('plus', t('Add new task color'), 'ConfigTaskColorController', 'edit', array(
    'plugin' => 'CRProject',
    'id' => 0
)) ?>