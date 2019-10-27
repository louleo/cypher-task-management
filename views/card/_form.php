<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Card */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    div.pell-content-custom-name {
        min-height: 200px;
        border: 1px solid lightgray;
        margin-top: .5em;
    }
</style>
<div class="card-form">

    <?php $form = ActiveForm::begin([
            'options'=>[
                  'class'=>'js-create-card-form'
                ],
    ]); ?>

    <?= $form->field($model, 'list_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'style'=>'display:none']) ?>

    <div id="description-editor" class="pell"></div>

    <?= $form->field($model->getNewAssignee(),'user_id')->dropDownList($model->getBoardUsersOptions(),['value'=>isset($model->assignee)?$model->assignee->id:0]);?>

    <?= $form->field($model, 'due_date')->textInput() ?>

    <?= $form->field($model, 'github_pr_link')->textInput() ?>

    <?= $form->field($model, 'total_used_time')->hiddenInput(['maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success js-create-card-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>

    const editor = pell.init({
        element: document.getElementById('description-editor'),
        onChange: html => {
            document.getElementById('card-description').textContent = html
        },
        defaultParagraphSeparator: 'p',
        styleWithCSS: true,
        actions: [
            'bold',
            'underline',
            'heading1',
            'heading2',
            'italic',
            'paragraph',
            'quote',
            'olist',
            'ulist',
            'code',
            'strikethrough',
            {
                name: 'backColor',
                icon: '<div style="background-color:lightgreen;">A</div>',
                title: 'Highlight Color',
                result: () => pell.exec('backColor', 'lightgreen')
            },
            {
                name: 'image',
                result: () => {
                    const url = window.prompt('Enter the image URL')
                    if (url) pell.exec('insertImage', url)
                }
            },
            {
                name: 'link',
                result: () => {
                    const url = window.prompt('Enter the link URL')
                    if (url) pell.exec('createLink', url)
                }
            }
        ],
        classes: {
            actionbar: 'pell-actionbar',
            button: 'pell-button',
            content: 'pell-content',
            selected: 'pell-button-selected'
        }
    });
    editor.content.innerHTML = '<?=str_replace("'","\\'",$model->description);?>';
</script>

<script>
    // $('.js-create-card-btn').on('click',function (e) {
    //     e.preventDefault();
    //     $.ajax({
    //         url:'/card/create',
    //         method:'POST',
    //         data:$('.js-create-card-form').serialize(),
    //         success:function (data) {
    //             if (data.flag){
    //                 $('#create-modal-label').html('');
    //                 $('#create-modal-content').html('');
    //                 $('#board-create').modal({show:false});
    //             }
    //             console.log(data.data);
    //         }
    //     });
    // });
    $('#card-due_date').datepicker();
    $('#card-start_date').datepicker();
    $('#card-end_date').datepicker();
</script>