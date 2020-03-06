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
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Oswald:200,300,400,500,600,700|Play:400,700&display=swap" rel="stylesheet">
    <?php $this->head() ?>
    <?php if(YII_ENV_PROD):?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-N2FHJ2X');</script>
    <!-- End Google Tag Manager -->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-149442252-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-149442252-1');
    </script>
    <?php endif; ?>
</head>

<body>
<?php if(YII_ENV_PROD):?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N2FHJ2X"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php endif; ?>
<?php $this->beginBody() ?>
<?php
    if (isset($this->params['index'])){
        ?>
        <div class="w-100 h-100 bg-dark index-entry">
            <div class="index-entry-left"></div>
            <div class="index-entry-right"></div>
            <div class="h-100 index-entry-img mx-auto"></div>
            <script>
                $(document).ready(function(){
                    var audio = new Audio('/audio/mix_12s.mp3');
                    audio.play();
                    var timing =[3,5,7,8.5,11,12];
                    var urls = ['/img/2.jpg','/img/ji.jpg','/img/3.jpg','/img/5.jpg','/img/6.jpg','/img/4.jpg'];
                    setTimeout(function(){
                        $('.page-body').removeClass('d-none');
                        $('.index-entry').remove();
                    },12000);
                    for (var i = 0; i< timing.length; i++){
                        setTimeout(function (url,ti) {
                            $('.index-entry-img').css('background-image',"url('"+url+"')");
                            if (ti == 1){
                                $('.index-entry-img').css('width',"70%");
                            }
                            if (ti > 1){
                                $('.index-entry-img').css('width',"100%");
                            }
                        },1000*timing[i],urls[i],i);
                    };
                    $('.index-entry-left').addClass('entering');
                    $('.index-entry-right').addClass('entering');
                });
            </script>
        </div>
<?php
    }
?>

<div class="page-body <?= isset($this->params['index'])?"d-none":"" ?>">
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
                        <a class="nav-link site-button-a site-draw" href="#">Products and Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link site-button-a site-draw" href="#">Blogs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link site-button-a site-draw" href="/site/about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <?php
                            if(Yii::$app->user->isGuest):
                        ?>
                        <a class="nav-link site-button-a site-draw" href="/site/login">Log In</a>
                        <?php
                            else:
                        ?>
                        <a class="nav-link site-button-a site-draw" href="/board/">Board</a>
                        <?php
                            endif;
                        ?>
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
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
