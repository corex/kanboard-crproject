<?php

use Kanboard\Plugin\CRProject\Helper\Factory;

$header = count($values) > 0 ? 'Edit task color' : 'New task color';
$id = isset($values['id']) ? intval($values['id']) : 0;
$colorHelper = Factory::colorHelper();
?>
<div class="page-header">
    <h2><?= t($header) ?></h2>
</div>
<form method="post" action="<?= $this->url->href('ConfigTaskColorController', 'update', array('plugin' => 'CRProject')) ?>"
      autocomplete="off">
    <?= $this->form->csrf() ?>
    <?= $this->form->hidden('id', $values) ?>
    <?= $this->form->hidden('position', $values) ?>

    <?= $this->form->label(t('Color'), 'color_id') ?>
    <?php if ($id > 0): ?>
        <div class="color-picker-option">
            <div class="color-picker-square color-<?= $values['color_id'] ?>"></div>
            <div class="color-picker-label"><?= $colorHelper->name($values['color_id']) ?></div>
        </div>
    <?php else: ?>
        <?= $this->form->select('color_id', $colors, $values, array(), array(), 'color-picker') ?>
    <?php endif; ?>

    <?= $this->form->label(t('Title'), 'title') ?>
    <?= $this->form->text('title', $values, $errors, array('autofocus', 'required', 'maxlength="50"')) ?>

    <?= $this->modal->submitButtons() ?>
</form>
