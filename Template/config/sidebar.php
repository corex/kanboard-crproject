<li <?= $this->app->checkMenuSelection('ConfigStatusController', 'show', 'CRProject') ?>>
    <?= $this->url->link(t('Project status'), 'ConfigStatusController', 'show', ['plugin' => 'CRProject']) ?>
</li>
<li <?= $this->app->checkMenuSelection('ConfigPlatformController', 'show', 'CRProject') ?>>
    <?= $this->url->link(t('Project platform'), 'ConfigPlatformController', 'show', ['plugin' => 'CRProject']) ?>
</li>
