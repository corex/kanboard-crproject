<div class="dropdown">
    <a href="#" class="dropdown-menu dropdown-menu-link-icon"><i class="fa fa-cog"></i><i class="fa fa-caret-down"></i></a>
    <ul>
        <li>
            <?= $this->modal->medium('edit', t('Edit'), 'ConfigStatusController', 'edit',
                array('plugin' => 'CRProject', 'id' => $id)) ?>
        </li>
        <li>
            <?= $this->modal->confirm('trash-o', t('Remove'), 'ConfigStatusController', 'confirm',
                array('plugin' => 'CRProject', 'id' => $id)) ?>
        </li>
    </ul>
</div>
