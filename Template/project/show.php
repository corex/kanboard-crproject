<?php $statusDescription = null; ?>
<div class="page-header">
    <h2><?= t('Project board') ?></h2>
</div>
<div class="views-switcher-component">
    <ul class="views">
        <?php $classString = $statusShowId == 0 ? ' class="active"' : '' ?>
        <li<?= $classString ?>> <?= $this->url->link(t('Board'), 'DashboardController', 'show',
                array('plugin' => 'CRProject')) ?> </li>

        <?php $classString = $statusShowId == -1 ? ' class="active"' : '' ?>
        <li<?= $classString ?>> <?= $this->url->link(t('Show projects with no status or hidden'), 'DashboardController', 'show',
                array('plugin' => 'CRProject', 'status_show_id' => -1)) ?> </li>
    </ul>
</div>
<br>

<?php if ($statusShowId == -1): ?>

    <?php if ($statusDescription !== null): ?>
        <strong><?= $statusDescription ?></strong><br><br>
    <?php endif; ?>
    <table id="crtable" class="table-list table-striped table-scrolling">
        <thead>
        <tr>
            <th class="column-75"><?= t('Project') ?></th>
            <th class="column-15" style="text-align: center;"><?= t('Status') ?></th>
            <th class="column-10" style="text-align: center;"><?= t('Hidden') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($projects as $project): ?>
            <?php
            $projectId = $project['id'];

            $projectStatus = isset($projectStatuses[$projectId]) ? $projectStatuses[$projectId] : null;
            if (!in_array($projectId, $projectIds) && intval($projectStatus['is_hidden']) == 0) {
                continue;
            }

            $projectStatus = isset($projectStatuses[$projectId]) ? $projectStatuses[$projectId] : null;
            $colorId = !empty($projectStatus['color_id']) ? $projectStatus['color_id'] : null;
            ?>
            <tr class="table-list-row <?= $colorId !== null ? 'color-' . $colorId : '' ?>">
                <td class="column-75" style="vertical-align: middle;">
                    <?= $this->render('CRProject:project/dropdown', array(
                        'id' => $project['id'],
                        'statuses' => $statuses,
                        'projectStatus' => $projectStatus,
                        'project' => $project,
                        'statusShowId' => $statusShowId
                    )) ?>
                    <span class="table-list-title a">
                        <?= $this->url->link($this->text->e($project['name']), 'BoardViewController', 'show',
                            array('project_id' => $project['id'])) ?>
                    </span>
                </td>
                <td class="column-15" style="text-align: center; vertical-align: middle;">
                    <?php
                    $title = '';
                    if ($projectStatus !== null) {
                        $title = $projectStatus['title'];
                        if ($projectStatus['is_visible'] !== null) {
                            $isVisible = $projectStatus['is_visible'] == 1;
                            $title .= ' (' . ($isVisible ? t('Visible') : t('Hidden')) . ')';
                        }
                    }
                    ?>
                    <nobr><?= $title ?></nobr>
                </td>
                <td class="column-10" style="text-align: center; vertical-align: middle;">
                    <?= isset($projectStatuses[$projectId]) && $projectStatuses[$projectId]['is_hidden'] ? t('Yes') : t('No') ?>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php endif; ?>

<?php
// Calculate column width etc.
$numberOfColumns = count($statuses);
$columnPercent = intval(100 / $numberOfColumns);

$iconEye = '<i class="fa fa-fw fa-eye"></i>';
?>
<table>

    <!-- Show all status headers. -->
    <tr>
        <?php foreach ($statuses as $status): ?>
            <th style="padding: 5px 5px 5px 5px;">
                <?= $status['title'] ?>
                <i class="fa fa-info-circle" style="color: gray;" title="<?= $status['description'] ?>"></i>
            </th>
        <?php endforeach; ?>
    </tr>

    <!-- Show project for each status column. -->
    <tr>
        <?php foreach ($statuses as $status): ?>
            <td valign="top" style="padding: 5px 5px 5px 5px; width: <?= $columnPercent ?>%; white-space: nowrap;">

                <table border="0" style="border: 0px;">
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <?php

                            // Validate status id.
                            $statusId = $status['id'];
                            if (!isset($projectIdsByStatusIds[$statusId])) {
                                continue;
                            }

                            // Validate project id.
                            $projectId = $project['id'];
                            if (!in_array($projectId, $projectIdsByStatusIds[$statusId])) {
                                continue;
                            }
                            ?>

                            <!-- Show dropdown. -->
                            <td align="right" style="border: 0;">
                                <?= $this->render('CRProject:project/dropdown', array(
                                    'id' => $project['id'],
                                    'statuses' => $statuses,
                                    'projectStatus' => $projectStatus,
                                    'project' => $project,
                                    'statusShowId' => $statusShowId
                                )) ?>
                            </td>

                            <!-- Show title. -->
                            <td style="border: 0;">
                                <span class="table-list-title a">
                                    <?= $this->url->link($this->text->e($project['name']), 'BoardViewController',
                                        'show',
                                        array('project_id' => $project['id'])) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        <?php endforeach; ?>
    </tr>
</table>