<li>
    <?= $this->url->link(t('Project status'), 'ConfigStatusController', 'show', ['plugin' => 'CRProject']) ?>
</li>
<li>
    <?= $this->url->link(t('Project board'), 'DashboardController', 'show', ['plugin' => 'CRProject']) ?>
</li>