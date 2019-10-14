<div class="dropdown">
    <a href="#" class="dropdown-menu dropdown-menu-link-icon">
        <nobr><strong>#<?= $project['id'] ?> <i class="fa fa-caret-down"></i></strong></nobr>
    </a>
    <ul>
        <li>
            <?php
            $isHidden = $projectStatus !== null ? intval($projectStatus['is_hidden']) == 1 : false;
            $title = $isHidden ? t('Show') : t('Hide');
            $parameters = array('plugin' => 'CRProject', 'project_id' => $id, 'status_show_id' => $statusShowId);
            ?>
            <?= $this->url->icon('eye', t($title), 'DashboardController', 'visibility', $parameters) ?>
        </li>
        <li>
            <?= $this->url->icon('cog', t('Edit project'), 'ProjectEditController', 'show',
                array('project_id' => $project['id'])) ?>
        </li>
        <li>
            <?php
            $isFocused = $projectStatus !== null ? intval($projectStatus['is_focused']) == 1 : false;
            $title = $isFocused ? t('Unmark project as focused') : t('Mark project as focused')
            ?>
            <?= $this->url->icon(
                'star',
                $title,
                'DashboardController',
                'focus',
                array('plugin' => 'CRProject', 'project_id' => $id, 'status_show_id' => $statusShowId)
            ) ?>
        </li>
        <li>
            <?php
            $parameters = array(
                'plugin' => 'CRProject',
                'project_id' => $id,
                'status_id' => 0,
                'status_show_id' => $statusShowId
            );
            ?>
            <?= $this->url->icon('folder', t('Status: None'), 'DashboardController', 'status', $parameters) ?>
        </li>
        <?php foreach ($statuses as $status): ?>
            <?php
            $title = $status['title'];
            $isVisible = $status['is_visible'] == 1;
            ?>
            <li>
                <?php
                $parameters = array(
                    'plugin' => 'CRProject',
                    'project_id' => $id,
                    'status_id' => $status['id'],
                    'status_show_id' => $statusShowId
                );
                ?>
                <?= $this->url->icon('folder', t('Status') . ': ' . $title, 'DashboardController', 'status',
                    $parameters) ?>
            </li>
        <?php endforeach; ?>
        <li>
            <?php
            $parameters = array(
                'plugin' => 'CRProject',
                'project_id' => $id,
                'platform_id' => 0,
                'status_show_id' => $statusShowId
            );
            ?>
            <?= $this->url->icon('folder', t('Platform: None'), 'DashboardController', 'platform', $parameters) ?>
        </li>
        <?php foreach ($platforms as $platform): ?>
            <?php
            $title = $platform['title'];
            ?>
            <li>
                <?php
                $parameters = array(
                    'plugin' => 'CRProject',
                    'project_id' => $id,
                    'platform_id' => $platform['id'],
                    'status_show_id' => $statusShowId
                );
                ?>
                <?= $this->url->icon('server', t('Platform') . ': ' . $title, 'DashboardController', 'platform',
                    $parameters) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
