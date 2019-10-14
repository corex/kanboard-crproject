<div class="page-header">
    <h2><?= t('Remove status') ?></h2>
</div>

<div class="confirm">
    <div class="alert alert-info">
        <?= t('Do you really want to remove this status?') ?>
        <ul>
            <li>
                <strong><?= $this->text->e($values['title']) ?></strong>
            </li>
        </ul>
    </div>

    <?= $this->modal->confirmButtons(
        'ConfigPlatformController',
        'remove',
        array('plugin' => 'CRProject', 'id' => $values['id'])) ?>
</div>
