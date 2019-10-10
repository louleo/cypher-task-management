<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Card */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>
    div.card-view-container{
        margin-top: 3em;
        background-color: #f4f5f7;
        border-radius: 2px;
        padding: 3em 2em;
        max-width: 1440px;
    }
    div.card-title-wrapper{
        padding: .5em 1em;
    }
    div.card-main-detail-title-wrapper{
        padding: .5em 1em;
    }
    div.card-description-text-wrapper{
        min-height: 200px;
        padding: .5em 1.2em;
    }
    div.card-sidebar-item-wrapper{
        padding: .3em 1em;
    }
    div.card-sidebar-item-title-wrapper{
        background-color: rgba(9,30,66,.04);
        box-shadow: none;
        border: none;
        border-radius: 3px;
        box-sizing: border-box;
        display: block;
        margin-top: 8px;
        max-width: 300px;
        overflow: hidden;
        padding: 6px 12px;
        position: relative;
        text-decoration: none;
        text-overflow: ellipsis;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        white-space: nowrap;
        transition-property: background-color,border-color,box-shadow;
        transition-duration: 85ms;
        transition-timing-function: ease;
        text-align: center;
    }
    div.card-sidebar-item-content-wrapper{
        background-color: rgba(9,30,66,.04);
        box-shadow: none;
        border: none;
        border-radius: 3px;
        box-sizing: border-box;
        display: block;
        margin-top: 8px;
        max-width: 300px;
        overflow: hidden;
        padding: 6px 12px;
        position: relative;
        text-decoration: none;
        text-overflow: ellipsis;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        white-space: nowrap;
        transition-property: background-color,border-color,box-shadow;
        transition-duration: 85ms;
        transition-timing-function: ease;
        text-align: center;
    }
    div.card-comment-content-wrapper{
        background-color: #fff;
        border-radius: 3px;
        box-shadow: 0 1px 2px -1px rgba(9,30,66,.25),0 0 0 1px rgba(9,30,66,.08);
        box-sizing: border-box;
        clear: both;
        display: inline-block;
        margin: 4px 2px 4px 0;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
        padding: .5em 1em;
    }
    div.card-add-comment-wrapper{
        padding: 8px 12px;
        position: relative;
        transition-duration: 85ms;
        transition-timing-function: ease;
        transition-property: padding-bottom;
    }
    span.comment-details-inline-space{
        display: inline-block;
        min-width: 10px;
    }
    .comment-details-datetime-span{
        font-size: 12px;
        font-weight: 400;
        white-space: pre;
        padding-top: .5em;
    }
    div.card-comment-details-wrapper{
        padding: .3em 1.2em;
    }
</style>
<div class="card-view">

    <div class="container card-view-container" >
        <div class="card-title-wrapper">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="row">
            <div class="col-lg-8 col-xl-9">
                <div class="container-fluid">
                    <div class="row">
                        <div class="card-main-detail-title-wrapper">
                            <h3>Description</h3>
                        </div>
                        <div class="container-fluid card-description-text-wrapper" >
                            <?=$model->description;?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card-main-detail-title-wrapper">
                            <h3>Comments</h3>
                        </div>
                        <div class="container-fluid">
                            <div class="card-comments-wrapper">
                            <?php
                                $comments = $model->comments;
                                if (isset($comments)){
                                    foreach ($comments as $comment){
                                      ?>
                            <div class="card-comment-wrapper">
                                <div class="card-comment-details-wrapper">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <span><strong><?=$comment->author->username;?></strong></span>
                                            <span class="comment-details-inline-space"> </span>
                                            <span class="comment-details-datetime-span"><?=$comment->lastModifiedDate?></span>
                                        </div>
                                        <div class="col-lg-4" style="text-align: right;">
                                            <?php
                                            if ($comment->created_user_id == Yii::$app->user->id || Yii::$app->user->can('admin')){
                                                ?>
                                                <a href="/comment/delete/?id=<?=$comment->id?>" data-method="POST" class="comment-details-datetime-span">Delete</a>
                                                <?php
                                            }
                                            ?>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-comment-content-wrapper">
                                    <?=$comment->content?>
                                </div>
                            </div>
                                        <?php
                                    }
                                }
                            ?>
                        </div>
                            <div class="card-add-comment-wrapper">
                                <?php
                                $new_comment = $model->getNewComment();
                                $form = ActiveForm::begin(['action'=>'/comment/create']); ?>

                                <?= $form->field($new_comment, 'content')->textarea(['rows' => 6])->label(false) ?>

                                <?= $form->field($new_comment, 'card_id')->hiddenInput(['value'=>$model->id])->label(false) ?>

                                <div class="form-group">
                                    <?= Html::submitButton('Comment', ['class' => 'btn btn-success']) ?>
                                </div>

                                <?php ActiveForm::end(); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-3">
                <div class="container-fluid">
                    <div class="row card-sidebar-item-wrapper">
                        <div class="col-lg-6 card-sidebar-item-title-wrapper">Code</div>
                        <div class="col-lg-6 card-sidebar-item-content-wrapper"><?=$model->boardCode?></div>
                    </div>
                    <div class="row card-sidebar-item-wrapper">
                        <div class="col-lg-6 card-sidebar-item-title-wrapper">
                            Assignee
                        </div>
                        <div class="col-lg-6 card-sidebar-item-content-wrapper">
                            <select id="cardUserAssign" data-card-id="<?=$model->id?>" >
                                <?php
                                $boardUsers = $model->getBoardUsers();
                                if (isset($model->assignee)){
                                    $assignee_id = $model->assignee->id;
                                }else{
                                    $assignee_id = null;
                                }
                                if (isset($boardUsers)){
                                    foreach ($boardUsers as $boardUser){
                                        ?>
                                        <option value="<?=$boardUser->id?>" <?=($boardUser->id == $assignee_id)?'selected':''?> ><?=$boardUser->userName?></option>
                                        <?php
                                    }
                                }
                                ?>
                                <option value="0" <?=isset($assignee_id)?'':'selected';?> >--Select--</option>
                            </select>
                        </div>
                    </div>
                    <div class="row card-sidebar-item-wrapper">
                        <div class="col-lg-6 card-sidebar-item-title-wrapper">Start Date</div>
                        <div class="col-lg-6 card-sidebar-item-content-wrapper"><?=$model->start_date?></div>
                    </div>
                    <div class="row card-sidebar-item-wrapper">
                        <div class="col-lg-6 card-sidebar-item-title-wrapper">Due Date</div>
                        <div class="col-lg-6 card-sidebar-item-content-wrapper"><?=$model->due_date?></div>
                    </div>
                    <div class="row card-sidebar-item-wrapper">
                        <div class="col-lg-6 card-sidebar-item-title-wrapper">End Date</div>
                        <div class="col-lg-6 card-sidebar-item-content-wrapper"><?=$model->end_date?></div>
                    </div>
                    <div class="row card-sidebar-item-wrapper">
                        <div class="col-lg-6 card-sidebar-item-title-wrapper">Creator</div>
                        <div class="col-lg-6 card-sidebar-item-content-wrapper">
                            <?=$model->creator->username;?>
                        </div>
                    </div>
                    <div class="row card-sidebar-item-wrapper">
                        <div class="col-lg-6 card-sidebar-item-title-wrapper">In List</div>
                        <div class="col-lg-6 card-sidebar-item-content-wrapper">
                            <select id="cardMoveToSelect" data-card-id="<?=$model->id?>" >
                                <?php
                                    $modelLists = $model->getBoardLists();
                                    if (isset($modelLists)){
                                        foreach ($modelLists as $modelList){
                                            ?>
                                            <option value="<?=$modelList->id?>" <?=($modelList->id == $model->list_id)?'selected':''?> ><?=$modelList->name?></option>
                                <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row card-sidebar-item-wrapper">
                        <div class="col-lg-6 card-sidebar-item-title-wrapper">Action</div>
                        <div class="col-lg-6 card-sidebar-item-content-wrapper">
                            <?= Html::a('Edit', ['update', 'id' => $model->id]) ?>
                        </div>
                    </div>
                    <?php
                        if(isset($model->github_pr_link) && !empty($model->github_pr_link)){
                            ?>
                            <div class="row card-sidebar-item-wrapper">
                                <div class="col-lg-6 card-sidebar-item-title-wrapper">Github</div>
                                <div class="col-lg-6 card-sidebar-item-content-wrapper">
                                    <a href="<?=$model->github_pr_link?>" class="btn btn-info" style="width: 100%;" >Pathway</a>
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                    <div class="row card-sidebar-item-wrapper">
                        <a href="/board/view/<?=$model->list->board->id?>" class="btn btn-secondary" style="width: 100%;" >Back To Board</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="card-modal-alert" tabindex="-1" role="dialog" aria-labelledby="cardModalAlertLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cardModalAlertLabel">Title</h5>
                <button type="button" class="close js-card-modal-close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="card-modal-alert-content">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary js-card-modal-close-btn" data-dismiss="modal" id="card-modal-close-btn">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $('.js-card-modal-close-btn').on('click',function () {
       if ($('#card-move-to-confirm-btn').length){
           $('#card-move-to-confirm-btn').remove();
       }
    });
    $('#cardMoveToSelect').on('change',function () {
        $('#card-modal-close-btn').before('<button type="button" class="btn btn-secondary btn-danger" id="card-move-to-confirm-btn">Move</button>');
        $('#card-move-to-confirm-btn').on('click',function () {
            $.ajax({
                url:'/card/move-to',
                data:{'list_id': $('#cardMoveToSelect').val(),'card_id': $('#cardMoveToSelect').data('card-id')},
                method:'GET',
                success:function (data) {
                    $('#card-modal-alert').modal('hide');
                    if ($('#card-move-to-confirm-btn').length){
                        $('#card-move-to-confirm-btn').remove();
                    }
                    if (!data.flag){
                        $('#cardModalAlertLabel').html('Alert');
                        $('#card-modal-alert-content').html('Moving is unsuccessful, please try later.');
                        $('#card-modal-alert').modal({show:true});
                    }
                }
            });
        });
       $('#cardModalAlertLabel').html('Alert');
       $('#card-modal-alert-content').html('Do you want to move this card to '+$(this).find('option:selected').html());
        $('#card-modal-alert').modal({show:true});
    });
    $('#cardUserAssign').on('change',function () {
            $.ajax({
                url:'/card/user-assign',
                data:{'user_id': $('#cardUserAssign').val(),'card_id': $('#cardUserAssign').data('card-id')},
                method:'GET',
                success:function (data) {
                    if (!data.flag){
                        $('#cardModalAlertLabel').html('Alert');
                        $('#card-modal-alert-content').html('Assignment is unsuccessful, please try later.');
                        $('#card-modal-alert').modal({show:true});
                    }
                }
            });
    });
</script>