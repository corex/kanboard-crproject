<div class="dropdown">
    <a href="#" class="dropdown-menu dropdown-menu-link-icon"><i class="fa fa-cog"></i><i class="fa fa-caret-down"></i></a>
    <ul>
        <li>
            <?= $this->modal->medium('edit', t('Edit'), 'ConfigPlatformController', 'edit',
                array('plugin' => 'CRProject', 'id' => $platform['id'])) ?>
        </li>
        <li>
            <?= $this->modal->confirm('trash-o', t('Remove'), 'ConfigPlatformController', 'confirm',
                array('plugin' => 'CRProject', 'id' => $platform['id'])) ?>
        </li>
    </ul>
</div>
