<?php
/**
 * Team:LOVEYII,NKU
 * coding by 刘芳宜 2213925,20241218
 * This is the main layout of frontend web.
 */


/* @var $this yii\web\View */
/* @var $members array 这个数组包含从数据库中获取的成员数据 */

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
        overflow-y: auto;
        position: relative;
    }

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
        margin-top: 20px;
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
        <p>小组致力于做出ai相关的网页以发现更多的ai交流爱好者研究者。</p>

        <div class="leader-section">
            <img src="<?= Yii::getAlias('@web') ?>/assets/images/背景图片1.jpg" alt="Leader Photo">
            <h2>Leader: <?= Html::encode($leader->membername) ?></h2> <!-- 显示数据库中的Leader姓名 -->
            <p><?= Html::encode($leader->zuzhangorduiyuan) ?></p> <!-- 显示 Leader 的分工 -->
            <p><strong>负责：</strong> <?= Html::encode($leader->memberhomework) ?></p> <!-- 显示 Leader 的作业 -->
            <!-- 生成下载链接，指向 data/team 文件夹下的 ZIP 文件 -->
            <a href="<?= Yii::getAlias('@web') ?>/data/personal/<?= Html::encode($leader->memberhomework) ?>.zip" class="download-button" download>下载个人作业</a>
        </div>

        <div class="team">
            <h2>Meet the Team</h2>

            <?php foreach ($members as $member): ?>
                <!-- 检查当前成员是否为Leader，如果是则跳过 -->
                <?php if ($member->zuzhangorduiyuan === 'leader') continue; ?>
                <div class="team-member">
                    <img src="<?= Yii::getAlias('@web') ?>/assets/images/背景图片2.jpg" alt="Team Member">
                    <span><?= Html::encode($member->membername) ?> ✔</span> <!-- 显示数据库中的姓名并添加符号 -->
                    <p><?= Html::encode($member->zuzhangorduiyuan) ?></p> <!-- 显示分工部分 -->
                    <p><strong>负责：</strong> <?= Html::encode($member->memberhomework) ?></p> <!-- 显示作业 -->
                    <!-- 生成下载链接，指向 data/team 文件夹下的 ZIP 文件 -->
                    <a href="<?= Yii::getAlias('@web') ?>/data/personal/<?= Html::encode($member->memberhomework) ?>.zip" class="download-button" download>下载个人作业</a>
                </div>
            <?php endforeach; ?>
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
