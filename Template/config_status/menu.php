<div class="dropdown">
    <a href="#" class="dropdown-menu dropdown-menu-link-icon"><i class="fa fa-cog"></i><i class="fa fa-caret-down"></i></a>
    <ul>
        <li>
            <?= $this->modal->medium('edit', t('Edit'), 'ConfigStatusController', 'edit',
                array('plugin' => 'CRProject', 'id' => $id)) ?>
        </li>
        <li>
            <?php if (!in_array($id, $statusIdsInUse)): ?>
                <?= $this->modal->confirm('trash-o', t('Remove'), 'ConfigStatusController', 'confirm',
                    array('plugin' => 'CRProject', 'id' => $id)) ?>
            <?php else: ?>
                <?= t('Status in use. Now allowed to remove.') ?>
            <?php endif; ?>
        </li>
    </ul>
</div>
