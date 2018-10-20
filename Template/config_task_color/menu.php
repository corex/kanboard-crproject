<div class="dropdown">
    <a href="#" class="dropdown-menu dropdown-menu-link-icon"><i class="fa fa-cog"></i><i class="fa fa-caret-down"></i></a>
    <ul>
        <li>
            <?= $this->modal->medium('edit', t('Edit'), 'ConfigTaskColorController', 'edit',
                array('plugin' => 'CRProject', 'id' => $color['id'])) ?>
        </li>
        <li>
            <?= $this->modal->confirm('trash-o', t('Remove'), 'ConfigTaskColorController', 'confirm',
                array('plugin' => 'CRProject', 'id' => $color['id'])) ?>
        </li>
    </ul>
</div>
