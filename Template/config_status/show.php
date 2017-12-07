<?php
// We are cheating here and use "subtask" functionality (subtasks-table) to drag/drop.
$positionUrl = $this->url->href('ConfigStatusController', 'position', array('plugin' => 'CRProject'));
?>
    <div class="page-header">
        <h2><?= t('Project status') ?></h2>
    </div>
    <table id="crtable" class="subtasks-table table-striped table-scrolling"
           data-save-position-url="<?= $positionUrl ?>">
        <thead>
        <tr>
            <th class="column-90"><?= t('Title') ?></th>
            <th class="column-10" style="text-align: center;"><?= t('Visible') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($statuses as $status): ?>
            <tr data-subtask-id="<?= $status['id'] ?>">
                <td style="vertical-align: middle;">
                    <i class="fa fa-arrows-alt draggable-row-handle" title="<?= t('Change position') ?>"></i>&nbsp;
                    <?= $this->render('CRProject:config_status/menu', array(
                        'id' => $status['id'],
                        'statusIdsInUse' => $statusIdsInUse
                    )) ?>
                    <?= $status['title'] ?>
                </td>
                <td class="column-10"
                    style="text-align: center; vertical-align: middle;"><?= $status['is_visible'] == 1 ? t('Yes') : t('No') ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?= $this->modal->medium('plus', t('Add new status'), 'ConfigStatusController', 'edit', array(
    'plugin' => 'CRProject',
    'id' => 0
)) ?>