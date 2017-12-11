<div class="page-header">
    <h2><?= t('Project status') ?></h2>
</div>

<div class="views-switcher-component">
    <ul class="views">
        <?php $classString = $statusShowId == 0 ? ' class="active"' : '' ?>
        <li<?= $classString ?>> <?= $this->url->link(t('All'), 'DashboardController', 'show', array('plugin' => 'CRProject', 'status_show_id' => 0)) ?> </li>

        <?php foreach ($statuses as $status): ?>
            <?php $classString = $statusShowId == $status['id'] ? ' class="active"' : '' ?>
            <li<?= $classString ?>> <?= $this->url->link(t($status['title']), 'DashboardController', 'show', array('plugin' => 'CRProject', 'status_show_id' => $status['id'])) ?> </li>
        <?php endforeach ?>

        <?php $classString = $statusShowId === null ? ' class="active"' : '' ?>
        <li<?= $classString ?>> <?= $this->url->link(t('None'), 'DashboardController', 'show', array('plugin' => 'CRProject', 'status_show_id' => -1)) ?> </li>
    </ul>
</div>
<br>

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
        if (!in_array($projectId, $projectIds)) {
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