<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Board */

$this->title = $board->name;
\yii\web\YiiAsset::register($this);
?>
<div class="board-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="board-board">
        <div class="board-list">
            <button>Add New List</button>
        </div>
    </div>


</div>
