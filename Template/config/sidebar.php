<li <?= $this->app->checkMenuSelection('ConfigStatusController', 'show', 'CRProject') ?>>
    <?= $this->url->link(t('Project status'), 'ConfigStatusController', 'show', ['plugin' => 'CRProject']) ?>
</li>
<li>
    <?= $this->url->link(t('Project task color'), 'ConfigTaskColorController', 'show', ['plugin' => 'CRProject']) ?>
</li>
<li>
    <?= $this->url->link(t('Project board'), 'DashboardController', 'show', ['plugin' => 'CRProject']) ?>
</li>
