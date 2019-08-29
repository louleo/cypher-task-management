<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Card */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-form">

    <?php $form = ActiveForm::begin([
            'options'=>[
                  'class'=>'js-create-card-form'
                ],
    ]); ?>

    <?= $form->field($model, 'list_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'due_date')->textInput() ?>

    <?= $form->field($model, 'start_date')->textInput() ?>

    <?= $form->field($model, 'end_date')->textInput() ?>

    <?= $form->field($model, 'total_used_time')->hiddenInput(['maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success js-create-card-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $('.js-create-card-btn').on('click',function (e) {
        e.preventDefault();
        $.ajax({
            url:'/card/create',
            method:'POST',
            data:$('.js-create-card-form').serialize(),
            success:function (data) {
                if (data.flag){
                    $('#create-modal-label').html('');
                    $('#create-modal-content').html('');
                    $('#board-create').modal({show:false});
                }
                console.log(data.data);
            }
        });
    });
    $('#card-due_date').datepicker();
    $('#card-start_date').datepicker();
    $('#card-end_date').datepicker();
</script>