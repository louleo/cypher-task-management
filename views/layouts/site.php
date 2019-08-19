<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\SiteAsset;

SiteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <nav class="navbar navbar-expand-lg navbar-dark site-navbar-custom fixed-top">
        <div class="container-fluid" style="padding: 0;">
            <a class="navbar-brand" href="/" style="font-size: 2em;">Cypher</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto" style="text-align: center;">
                    <li class="nav-item">
                        <a class="nav-link site-button-a site-draw" href="/site/contact">Enquiries</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link site-button-a site-draw" href="#">Application Development</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link site-button-a site-draw" href="#">Products And Service</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link site-button-a site-draw" href="/site/about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link site-button-a site-draw" href="/site/login">Log In</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container-fluid" style="padding:0;">
        <?= $content ?>
    </div>
</div>

<footer class="py-5" style="background-image:url('/img/bg-bluepoly.png');">
    <div class="container">
        <p class="m-0 text-center text-white small" style="font-size: 1em;">Copyright &copy; Cypher Pty. Ltd. 2019</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
