<div class="page-header">
    <h2><?= t('Project status') ?></h2>
</div>
<table id="crtable" class="table-striped table-scrolling">
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
        ?>
        <tr>
            <td class="column-75" style="vertical-align: middle;">
                <?= $this->render('CRProject:project/menu', array(
                    'id' => $project['id'],
                    'statuses' => $statuses,
                    'projectStatus' => $projectStatus
                )) ?>
                <?= $project['name'] ?> <?= $project['id'] ?>
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