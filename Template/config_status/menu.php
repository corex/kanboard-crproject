<div class="dropdown">
    <a href="#" class="dropdown-menu dropdown-menu-link-icon"><i class="fa fa-cog"></i><i class="fa fa-caret-down"></i></a>
    <ul>
        <li>
            <?= $this->modal->medium('edit', t('Edit'), 'ConfigStatusController', 'edit',
                array('plugin' => 'CRProject', 'id' => $status['id'])) ?>
        </li>
        <li>
            <?= $this->modal->confirm('trash-o', t('Remove'), 'ConfigStatusController', 'confirm',
                array('plugin' => 'CRProject', 'id' => $status['id'])) ?>
        </li>
        <li>
            <?php if ($status['is_default'] == 1): ?>
                <?= $this->url->icon('star', t('Remove default'), 'ConfigStatusController', 'setDefault',
                    array('plugin' => 'CRProject', 'id' => $status['id'], 'is_default' => 0)) ?>
            <?php else: ?>
                <?= $this->url->icon('star', t('Set default'), 'ConfigStatusController', 'setDefault',
                    array('plugin' => 'CRProject', 'id' => $status['id'], 'is_default' => 1)) ?>
            <?php endif; ?>
        </li>
    </ul>
</div>
