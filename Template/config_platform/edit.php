<?php
$header = count($values) > 0 ? 'Edit platform' : 'New platform';
?>
<div class="page-header">
    <h2><?= t($header) ?></h2>
</div>
<form method="post" action="<?= $this->url->href('ConfigPlatformController', 'update', array('plugin' => 'CRProject')) ?>"
      autocomplete="off">
    <?= $this->form->csrf() ?>
    <?= $this->form->hidden('id', $values) ?>

    <?= $this->form->label(t('Title'), 'title') ?>
    <?= $this->form->text('title', $values, $errors, array('autofocus', 'required', 'maxlength="50"')) ?>

    <?= $this->form->label(t('Color'), 'color_id') ?>
    <?= $this->form->select('color_id', $colors, $values, array(), array(), 'color-picker') ?>

    <?= $this->modal->submitButtons() ?>
</form>
