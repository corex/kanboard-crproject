<?php
$columnCounts = array();
for ($columnCounter = 1; $columnCounter <= 8; $columnCounter++) {
    $columnCounts[$columnCounter] = $columnCounter;
}

$choices = array(
    '1' => t('Plugin project board'),
    '0' => t('Kanboard dashboard')
);

$isDefaultDashboard = $values['crproject_default_dashboard'] == 1;

?>
<fieldset>
    <legend><?= t('Project board') ?></legend>

    <?= $this->form->label(t('Number of columns'), 'crproject_column_count_title') ?>
    <?= $this->form->select('crproject_column_count', $columnCounts, $values, $errors) ?>

    <?= $this->form->label(t('Default frontpage (ENABLE_URL_REWRITE must be enabled)'), 'crproject_default_dashboard_title') ?>
    <?= $this->form->select('crproject_default_dashboard', $choices, $values, $errors) ?>

</fieldset>