<div class="dropdown">
    <a href="#" class="dropdown-menu dropdown-menu-link-icon">
        <nobr><strong>#<?= $project['id'] ?> <i class="fa fa-caret-down"></i></strong></nobr>
    </a>
    <ul>
        <li>
            <?php
            $isHidden = $projectStatus !== null ? intval($projectStatus['is_hidden']) == 1 : false;
            $title = $isHidden ? t('Show') : t('Hide');
            $parameters = array(
                'plugin' => 'CRProject',
                'id' => $id,
                'isHidden' => intval(!$isHidden),
                'status_show_id' => $statusShowId
            );
            ?>
            <?= $this->url->icon('eye', t($title), 'DashboardController', 'visibility', $parameters) ?>
        </li>
        <li>
            <?php
            $parameters = array(
                'plugin' => 'CRProject',
                'id' => $id,
                'statusId' => 0,
                'status_show_id' => $statusShowId
            );
            ?>
            <?= $this->url->icon('folder', t('None'), 'DashboardController', 'status', $parameters) ?>
        </li>
        <?php foreach ($statuses as $status): ?>
            <?php
            $title = $status['title'];
            $isVisible = $status['is_visible'] == 1;
            $title .= ' (' . ($isVisible ? t('Visible') : t('Hidden')) . ')';
            ?>
            <li>
                <?php
                $parameters = array(
                    'plugin' => 'CRProject',
                    'id' => $id,
                    'statusId' => $status['id'],
                    'status_show_id' => $statusShowId
                );
                ?>
                <?= $this->url->icon('folder', t($title), 'DashboardController', 'status', $parameters) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
