<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'LOVEYII小组';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        height: auto;
        margin: 0;
        overflow-y: auto; /* 允许垂直滚动 */
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

    .site-about {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 2;
        text-align: center;
        padding: 20px;
        margin-top: 20px; /* 适当调整顶部间距 */
    }

    .about-container {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        max-width: 800px;
        width: 100%;
        text-align: center;
        font-size: 12px;
    }

    /* Leader 部分样式 */
    .leader-section {
        margin-bottom: 30px;
        text-align: center;
    }

    .leader-section img {
        width: 100px;
        height: 100px;
        border-radius: 50%; 
        margin-bottom: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .leader-section h2 {
        font-size: 24px;
        color: #4e73df;
        margin-bottom: 10px;
    }

    .leader-section p {
        font-size: 16px;
        color: #333;
        margin-bottom: 20px;
    }

    .about-container h1 {
        font-size: 24px;
        color: #4e73df;
        margin-bottom: 20px;
    }

    .about-container p {
        font-size: 16px;
        color: #333;
        margin-bottom: 20px;
    }

    .team {
        margin-top: 30px;
    }

    .team h2 {
        font-size: 24px;
        color: #4e73df;
        margin-bottom: 15px;
    }

    .team-member {
        display: inline-block;
        margin: 10px;
        text-align: center;
        width: 200px;
    }

    .team-member img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-bottom: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .team-member span {
        font-size: 14px;
        font-weight: bold;
        color: #333;
        display: block;
        margin-top: 5px;
    }

    .team-member p {
        font-size: 12px;
        color: #666;
        margin-top: 5px;
    }

    .features {
        margin-top: 30px;
        text-align: center; 
    }

    .features h2 {
        font-size: 24px;
        color: #4e73df;
        margin-bottom: 15px;
    }

    .features ul {
        list-style: none;
        padding-left: 0;
        display: inline-block;
        text-align: left;
    }

    .features ul li {
        font-size: 14px;
        margin-bottom: 10px;
        color: #333;
        display: flex;
        align-items: center;
    }

    .features ul li::before {
        content: '✔️';
        color: #4e73df;
        margin-right: 10px;
    }

    /* 下载按钮样式 */
    .download-button {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 16px;
        background-color: #4e73df;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
    }

    .download-button:hover {
        background-color: #3e64a1;
    }
</style>

<div class="site-about">
    <div class="about-container">
        <!-- Leader 介绍 -->
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            小组致力于做出ai相关的网页以发现更多的ai交流爱好者研究者。
        </p>

        <div class="leader-section">
            <img src="<?= Yii::getAlias('@web') ?>/assets/images/背景图片1.jpg" alt="Leader Photo">
            <h2>Leader: 刘芳宜</h2>
            <p>负责前端整体框架和所有数据整合以及可视化</p>
            <a href="<?= Yii::getAlias('@web') ?>/data/team/lfy.zip" class="download-button" download>刘芳宜的个人作业</a>
        </div>


        <div class="team">
            <h2>Meet the Team</h2>
            <div class="team-member">
                <img src="<?= Yii::getAlias('@web') ?>/assets/images/背景图片2.jpg" alt="Team Member">
                <span>胡雨欣</span>
                <!-- <p>Founder & CEO</p> -->
                <p>负责后端整体框架</p>
                <a href="<?= Yii::getAlias('@web') ?>/data/team/hyx.zip" class="download-button" download>胡雨欣的个人作业</a>
            </div>
            <div class="team-member">
                <img src="<?= Yii::getAlias('@web') ?>/assets/images/背景图片2.jpg" alt="Team Member">
                <span>高玉格</span>
                <!-- <p>CTO</p> -->
                <p>负责前端后端评论功能</p>
                <a href="<?= Yii::getAlias('@web') ?>/data/team/gyg.zip" class="download-button" download>高玉格的个人作业</a>
            </div>
            <div class="team-member">
                <img src="<?= Yii::getAlias('@web') ?>/assets/images/背景图片3.jpg" alt="Team Member">
                <span>庞艾语</span>
                <!-- <p>负责前端搜索交互</p> -->
                <p>负责前端搜索交互</p>
                <a href="<?= Yii::getAlias('@web') ?>/data/team/pay.zip" class="download-button" download>庞艾语的个人作业</a>
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

<script>
    // 图片轮播效果
    let currentImageIndex = 0;
    const images = document.querySelectorAll('.background-slideshow img');
    const totalImages = images.length;

    setInterval(() => {
        images[currentImageIndex].classList.remove('active');
        currentImageIndex = (currentImageIndex + 1) % totalImages;
        images[currentImageIndex].classList.add('active');
    }, 5000);
</script>
