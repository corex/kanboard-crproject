<div class="page-header">
    <h2><?= t('Remove task color') ?></h2>
</div>

<div class="confirm">
    <div class="alert alert-info">
        <?= t('Do you really want to remove this task color?') ?>
        <ul>
            <li>
                <strong><?= $this->text->e($values['title']) ?></strong>
            </li>
        </ul>
    </div>

    <?= $this->modal->confirmButtons(
        'ConfigTaskColorController',
        'remove',
        array('plugin' => 'CRProject', 'id' => $values['id'])) ?>
</div>
