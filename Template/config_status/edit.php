<?php
$header = count($values) > 0 ? 'Edit status' : 'New status';
$isVisible = isset($values['is_visible']) ? $values['is_visible'] == 1 : false;
$isDefault = isset($values['is_default']) ? $values['is_default'] == 1 : false;
?>
<div class="page-header">
    <h2><?= t($header) ?></h2>
</div>
<form method="post" action="<?= $this->url->href('ConfigStatusController', 'update', array('plugin' => 'CRProject')) ?>"
      autocomplete="off">
    <?= $this->form->csrf() ?>
    <?= $this->form->hidden('id', $values) ?>
    <?= $this->form->hidden('position', $values) ?>
    <?= $this->form->hidden('is_default', $values) ?>

    <?= $this->form->label(t('Title'), 'title') ?>
    <?= $this->form->text('title', $values, $errors, array('autofocus', 'required', 'maxlength="255"')) ?>

    <?= $this->form->label(t('Color'), 'color_id') ?>
    <?= $this->form->select('color_id', $colors, $values, array(), array(), 'color-picker') ?>

    <?= $this->form->checkbox('is_visible', t('Visible'), 1, $isVisible) ?>

    <?= $this->modal->submitButtons() ?>
</form>
