<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;

$this->title = 'Загрузите фотографию';
?>
<div class="site-index">
    <h1><?= $this->title ?></h1>
    <?php if($model->errors) { ?>
        <div class="alert alert-danger">
            <?= \yii\helpers\Html::errorSummary($model); ?>
        </div>
    <?php } ?>

    <?php $form = ActiveForm::begin([
    ]) ?>
    <?= $form->field($model, 'file')->fileInput(); ?>
    <?= $form->field($model, 'email'); ?>
    <?= $form->field($model, 'description')->textarea(); ?>
    <button class="btn btn-default">Отправить</button>
    <?php ActiveForm::end() ?>
</div>
