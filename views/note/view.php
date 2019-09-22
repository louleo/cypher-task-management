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
<div class="note-view">
    
    <div class="container-fluid">
        <div class="row align-items-center" style="position: relative;">
            <h1 class="d-inline-block"><?= Html::encode($this->title) ?></h1>
            <?php
                if ($model->canEdit()){
                    ?>
                    <div class="col-lg-3 text-right " style="position: absolute; right: 0;">
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Edit', ['edit', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
        <div class="row py-2">
            <strong><em><?=$model->description?></em></strong>
        </div>
    </div>
    <hr>
    <div class="container-fluid">
        <?php
            foreach ($model->noteContents as $content){
                ?>
                <div class="row">
                    <div class="m-100 py-2 js-note-content" data-id="<?=$content->id?>"></div>
                </div>
        <?php
            }
        ?>
        <div class="row py-2">

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

</script>