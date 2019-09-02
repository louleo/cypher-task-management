<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Card */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card-view">

    <div class="container card-view-container" >
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="row">
            <div class="col-lg-9">
                <div class="container-fluid">
                    <div class="row">
                        <h3>Description</h3>
                        <div class="container-fluid" style="min-height: 200px;">
                            <?=$model->description;?>
                        </div>
                    </div>
                    <div class="row">
                        <h3>Comments</h3>
                        <div class="container-fluid">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="container-fluid">
                    <div class="row">
                        <h4>Assign to</h4>
                    </div>
                    <div class="row">
                        <h4>Start Date</h4>
                    </div>
                    <div class="row">
                        <h4>Due Date</h4>
                    </div>
                    <div class="row">
                        <h4>End Date</h4>
                    </div>
                    <div class="row">
                        <h4>Creator</h4>
                        <div class="container-fluid">
                            <?=$model->creator->username;?>
                        </div>
                    </div>
                    <div class="row">
                        <h4>Move To</h4>
                        <div class="container-fluid">
                            <select id="cardMoveToSelect" data-card-id="<?=$model->id?>">
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
                    <div class="row">
                            <?= Html::a('Edit', ['update', 'id' => $model->id],
                                [
//                                        'class' => 'btn btn-primary'
                                ]
                            ) ?>
                    </div>
                    <div class="row">
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
//                                'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                    <div class="row">
                        <a href="/board/view/<?=$model->list->board->id?>">Back To Board</a>
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
</script>