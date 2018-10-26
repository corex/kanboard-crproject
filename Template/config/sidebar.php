<li <?= $this->app->checkMenuSelection('ConfigStatusController', 'show', 'CRProject') ?>>
    <?= $this->url->link(t('Project status'), 'ConfigStatusController', 'show', ['plugin' => 'CRProject']) ?>
</li>
