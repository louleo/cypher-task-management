<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Board */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="board-form">

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'last_modified_user_id')->textInput() ?>

<?= $form->field($model, 'last_modified_date')->textInput() ?>

<?= $form->field($model, 'created_user_id')->textInput() ?>

<?= $form->field($model, 'created_date')->textInput() ?>

<?= $form->field($model, 'active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

    </div>
