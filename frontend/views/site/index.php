<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'World Artificial Intelligence Ranking 1996-2021';
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        height: 100vh;
        margin: 0;
        overflow: hidden;
        position: relative;
    }

    /* 背景图片轮播 */
    .background-slideshow {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        overflow: hidden;
    }

    .background-slideshow img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
        transition: opacity 1s ease-in-out;
        z-index: -1;
    }

    .background-slideshow img.active {
        opacity: 1;
        z-index: 0;
    }

    .site-index {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        z-index: 2;
        height: 100%;
        text-align: center;
        color: #fff;
    }

    .jumbotron {
        background-color: rgba(0, 0, 0, 0.5);
        padding: 40px;
        border-radius: 10px;
        margin-bottom: 30px;
    }

    .btn-success {
        background-color: #4e73df;
        border-color: #4e73df;
        color: #fff;
        font-size: 16px;
        padding: 10px 20px;
        border-radius: 5px;
    }

    .btn-success:hover {
        background-color: #3e63c9;
        border-color: #3e63c9;
    }

    .body-content {
        background-color: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 10px;
        max-width: 800px;
        margin: 0 auto;
    }

    .row {
        display: flex;
        justify-content: space-between;
    }

    .col-lg-4 {
        flex: 1;
        margin: 0 10px;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .col-lg-4 h2 {
        color: #4e73df;
    }

    .col-lg-4 p {
        color: #333;
    }

    .btn-default {
        background-color: #4e73df;
        color: #fff;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
    }

    .btn-default:hover {
        background-color: #3e63c9;
    }
</style>

<div class="site-index">
    <div class="jumbotron">
        <h1><?= Html::encode($this->title) ?></h1>
        <p class="lead">WELCOME TO THE MOVIE FORUM</p>
        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">
        <div class="row">
            <!-- 电影推荐部分 -->
            <div class="col-lg-4">
                <h2>paper about chronicle of AI</h2>
                <p>you can find movie with language</p>
                <p></p><a class="btn btn-default" href="<?= \yii\helpers\Url::to(['site/recommended']) ?>">See Recommended Movies &raquo;</a></p>

            </div>

            <!-- 热门电影部分 -->
            <div class="col-lg-4">
                <h2>know about chronicle of AI</h2>
                <p>you can find movie with type</p>
                <p><a class="btn btn-default" href="<?= \yii\helpers\Url::to(['site/popular']) ?>">View Popular Movies &raquo;</a></p>
            </div>

            <!-- 电影论坛部分 -->
            <div class="col-lg-4">
                <h2>AI tools</h2>
                <p>you can find movie with id</p>
                <p><a class="btn btn-default" href="<?= \yii\helpers\Url::to(['site/forum']) ?>">Visit the Forum &raquo;</a></p>
            </div>
        </div>
    </div>


</div>

<!-- 背景图片轮播 -->
<div class="background-slideshow">
    <img src="<?= Yii::getAlias('@web') ?>/assets/images/背景图片1.jpg" class="active">
    <img src="<?= Yii::getAlias('@web') ?>/assets/images/背景图片2.jpg">
    <img src="<?= Yii::getAlias('@web') ?>/assets/images/背景图片3.jpg">
</div>

<!-- 图片轮播 JavaScript -->
<script>
    let currentImageIndex = 0;
    const images = document.querySelectorAll('.background-slideshow img');
    const totalImages = images.length;

    setInterval(() => {
        images[currentImageIndex].classList.remove('active');
        currentImageIndex = (currentImageIndex + 1) % totalImages;
        images[currentImageIndex].classList.add('active');
    }, 5000);
</script>
