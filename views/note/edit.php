<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Note */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<style>
    div.note-content-can-edit{
        position: relative;
    }
    a.note-content-edit-btn{
        position: absolute;
        right: 0;
        display: none;
        z-index: 4;
        font-size: small;
        top: -1em;
    }

    div.note-content-can-edit:hover{
        border: solid 1px lightgreen;
        border-style: dotted;
    }

    div.note-content-can-edit:hover a.note-content-edit-btn{
        display: inline-block;
    }
</style>

<div class="note-view">
    
    <div class="container-fluid">
        <div class="row align-items-center" style="position: relative;">
            <h1 class="d-inline-block"><?= Html::encode($this->title) ?></h1>
            <?php
                if ($model->canEdit()){
                    ?>
                    <div class="col-lg-3 text-right " style="position: absolute; right: 0;">
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('View', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
            <?php
                }
            ?>
        </div>
        <div class="row py-2">
            <strong>Authored By: <?=$model->createdUser->fullName?></strong>
        </div>
        <div class="row py-2">
            <em>Last Updated On: <?=$model->lastModifiedDate?></em>
        </div>
        <div class="row py-2 note-content-can-edit">
            <strong><em><?=$model->description?></em></strong>
            <a class="btn btn-dark note-content-edit-btn" href="/note/update/<?=$model->id?>">Edit</a>
        </div>
    </div>
    <hr>
    <div class="container-fluid">
        <div class="row py-2">
            <div class="container-fluid js-contents-container">
                <?php
                foreach ($model->noteContents as $content){
                    ?>
                    <div class="row note-content-can-edit js-note-content-wrapper">
                        <div class="m-100 py-2 js-note-content" data-id="<?=$content->id?>"></div>
                        <a class="btn btn-dark note-content-edit-btn" href="/notecontent/update/<?=$content->id?>">Edit</a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="row py-2">
            <?= Html::a('Create New Content', ['/notecontent/create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>

<script>

    var contentsJSON = JSON.parse('<?=$model->noteContentsToJson()?>');
    var converter = new showdown.Converter();
    $('.js-note-content').each(function () {
       let text = contentsJSON[$(this).data('id')];
       if (typeof text !== "undefined"){
           $(this).html(converter.makeHtml(text));
       }
    });

    function contentReorder(content){
        $.ajax({
            url:'/notecontent/reorder',
            data:{'c_id': $(content).find('.js-note-content').data('id'),'c_order':$('.js-note-content-wrapper').index(content)+1},
            method:'GET',
            success:function () {
                alert('You movement is successfully performed.')
            },
            error:function (xhr, textStatus,errorThrown) {
                alert(errorThrown);
            }
        });
    }

    let dragulaArray = [$('.js-contents-container')[0]];

    dragula(dragulaArray).on('drop',function (el,target,source,sibling) {
        contentReorder(el);
    });

</script>