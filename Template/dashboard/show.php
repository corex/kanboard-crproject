<?php

use Kanboard\Plugin\CRProject\Helper\Factory;

$statusDescription = null;
$colorHelper = Factory::colorHelper();
$widgetHelper = Factory::widgetHelper();
?>
<div class="page-header">
    <h2><?= t('Project board') ?></h2>
</div>
<div class="views-switcher-component" style="margin-bottom: 10px;">
    <ul class="views">
        <?php
        $showNoStatusOrHidden = $statusShowId == -1;
        if ($showNoStatusOrHidden) {
            $title = t('Hide projects with no status or hidden');
            $params = array('plugin' => 'CRProject');
        } else {
            $title = t('Show projects with no status or hidden');
            $params = array('plugin' => 'CRProject', 'status_show_id' => -1);
        }
        ?>
        <li>
            <?= $this->url->link($title, 'DashboardController', 'show', $params) ?>
        </li>
    </ul>
</div>

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
            $isProjectHidden = $projectStatus !== null && intval($projectStatus['is_hidden']) == 1;
            $isProjectVisible = $projectStatus !== null && intval($projectStatus['is_visible']) == 1;

            if (!in_array($projectId, $projectIds) && !$isProjectHidden && $isProjectVisible) {
                continue;
            }

            $colorId = !empty($projectStatus['color_id']) ? $projectStatus['color_id'] : null;
            ?>
            <tr class="table-list-row <?= $colorId !== null ? 'color-' . $colorId : '' ?>">
                <td class="column-75" style="vertical-align: middle;">
                    <div align="right" style="width: 50px; display: table-cell;">
                        <?= $this->render('CRProject:dashboard/dropdown', array(
                            'id' => $project['id'],
                            'statuses' => $statuses,
                            'platforms' => $platforms,
                            'projectStatus' => $projectStatus,
                            'project' => $project,
                            'statusShowId' => $statusShowId
                        )) ?>
                    </div>
                    <div style="display: table-cell; word-wrap: break-word; word-break: break-all; padding-left: 5px;">
                        <span class="task-board-title table-list-title a">
                            <?= $this->url->link(
                                $this->text->e($project['name']),
                                'BoardViewController',
                                'show',
                                array('project_id' => $project['id'])
                            ) ?>
                        </span>
                    </div>
                </td>
                <td class="column-15" style="text-align: center; vertical-align: middle;">
                    <?php
                    $title = '';
                    if ($projectStatus !== null) {
                        $title = $projectStatus['title'];
                        if ($projectStatus['is_visible'] !== null) {
                            $isVisible = $projectStatus['is_visible'] == 1;
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
$columnCounter = 0;
$numberOfColumns = count($statuses);
$columnPercent = intval(100 / $columnCounterMax);
$iconEye = '<i class="fa fa-fw fa-eye"></i>';
?>
<table>

    <!-- Show project for each status column. -->
    <tr>
        <?php foreach ($statuses as $status): ?>
            <?php
            $isStatusVisible = isset($status['is_visible']) && intval($status['is_visible']) == 1;
            if (!$isStatusVisible) {
                continue;
            }
            ?>
            <td align="left" valign="top" style="padding: 5px 5px 5px 5px; width: <?= $columnPercent ?>%; border: 0;">

                <?php
                $colorId = $status['color_id'];
                $styles = array(
                    'background-color: ' . $colorHelper->background($colorId),
                    'border-color: ' . $colorHelper->border($colorId)
                );
                ?>

                <div class="task-board task-board-status-open" style="<?= implode('; ', $styles) ?>">

                    <div style="<?= 'border-bottom-color: ' . $colorHelper->border($colorId) ?>; padding: 4px 8px 4px 8px;">
                        <?= $status['title'] ?>
                        <i class="fa fa-info-circle" style="color: gray; float: right;"
                           title="<?= $status['description'] ?>"></i>
                    </div>
                    <br>
                    <?php foreach ($projects as $project): ?>
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

                        // Get project status.
                        $projectStatus = isset($projectStatuses[$projectId]) ? $projectStatuses[$projectId] : null;
                        $isFocused = $projectStatus !== null ? intval($projectStatus['is_focused']) == 1 : false;
                        $platformId = isset($projectStatus['platform_id']) ? intval($projectStatus['platform_id']) : 0;
                        $platform = isset($platformsAsOptions[$platformId]) ? $platformsAsOptions[$platformId] : null;
                        ?>

                        <!-- Show dropdown. -->
                        <div align="right" style="width: 50px; display: table-cell;">
                            <?= $this->render('CRProject:dashboard/dropdown', array(
                                'id' => $project['id'],
                                'statuses' => $statuses,
                                'platforms' => $platforms,
                                'projectStatus' => $projectStatus,
                                'project' => $project,
                                'statusShowId' => $statusShowId
                            )) ?>
                        </div>

                        <!-- Show title. -->
                        <div style="display: table-cell; word-wrap: break-word; word-break: break-all;">
                            <span class="task-board-title table-list-title a">
                            <?= $this->url->link(
                                $this->text->e($project['name']),
                                'BoardViewController',
                                'show',
                                array('project_id' => $project['id']),
                                false,
                                '',
                                $project['description']
                            ) ?> <?php if ($isFocused): ?><i style="color: yellow;" class="fa fa-fw fa-star" ></i><?php endif; ?>
                                <?php if ($platform != null): ?>
                                    <?= $widgetHelper->label($platform['color_id'], $platform['title']) ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        <br>
                    <?php endforeach; ?>
                </div>
            </td>

            <?php
            if ($columnCounter >= $columnCounterMax - 1) {
                print('</tr><tr>');
                $columnCounter = 0;
            } else {
                $columnCounter++;
            }
            ?>

        <?php endforeach; ?>
    </tr>
</table>