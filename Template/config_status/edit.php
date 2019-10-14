<?php
$header = count($values) > 0 ? 'Edit status' : 'New status';
$isVisible = isset($values['is_visible']) ? $values['is_visible'] == 1 : false;
?>
<div class="page-header">
    <h2><?= t($header) ?></h2>
</div>
<form method="post" action="<?= $this->url->href('ConfigStatusController', 'update', array('plugin' => 'CRProject')) ?>"
      autocomplete="off">
    <?= $this->form->csrf() ?>
    <?= $this->form->hidden('id', $values) ?>
    <?= $this->form->hidden('position', $values) ?>

    <?= $this->form->label(t('Title'), 'title') ?>
    <?= $this->form->text('title', $values, $errors, array('autofocus', 'required', 'maxlength="50"')) ?>

    <?= $this->form->label(t('Description'), 'description') ?>
    <?= $this->form->text('description', $values, $errors, array('maxlength="200"')) ?>

    <?= $this->form->label(t('Color'), 'color_id') ?>
    <?= $this->form->select('color_id', $colors, $values, $errors, array(), 'color-picker') ?>

    <?= $this->form->checkbox('is_visible', t('Visible'), 1, $isVisible) ?>

    <?= $this->modal->submitButtons() ?>
</form>
