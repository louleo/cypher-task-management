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
        <?php
            foreach ($board->lists as $list){
                ?>
                <div class="board-list">
                    <?php
                        foreach ($list->cards as $card){
                            ?>
                    <div class="board-list-card">
                        <?=$card->title?>
                    </div>
                    <?php
                        }
                    ?>
                    <div class="board-list-card">
                        <button>Add New Card</button>
                    </div>
                </div>
                <?php
            }
        ?>
        <div class="board-list">
            <button>Add New List</button>
        </div>
    </div>


</div>


<script>

</script>