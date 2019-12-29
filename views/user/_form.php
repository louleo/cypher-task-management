<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dob')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])?>

    <?= $form->field($contact, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($contact, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($contact, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($contact, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($contact, 'nick_name')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <script>
        $('#user-dob').datepicker({dateFormat:'yy-mm-dd'});
    </script>
</div>
