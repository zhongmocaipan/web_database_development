<?php
/* @var $this yii\web\View */

$this->title = 'Video Player';
?>

<style>
    body {
        margin: 0;
        padding: 0;
        background-color: #00d1e0;
        font-family: Arial, sans-serif;
    }

    .background-slideshow {
        position: fixed;
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
        animation: fadeInOut 15s infinite;
    }

    .background-slideshow img:nth-child(2) {
        animation-delay: 5s;
    }

    .background-slideshow img:nth-child(3) {
        animation-delay: 10s;
    }

    @keyframes fadeInOut {
        0%, 100% { opacity: 0; }
        10%, 90% { opacity: 1; }
    }

    .video-container {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 90vh;
        overflow: hidden;
    }

    .video-item {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        transition: all 0.5s ease;
        cursor: pointer;
    }

    .video-left {
        left: 0%;
        width: 45%;
        opacity: 0.8;
    }

    .video-right {
        right: 0%;
        width: 45%;
        opacity: 0.8;
    }

    .video-center {
        width: 70%;
        z-index: 2;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.6);
    }

    video {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }

    .nav-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        border: none;
        font-size: 2rem;
        padding: 10px 15px;
        cursor: pointer;
        z-index: 3;
        border-radius: 5px;
        transition: all 0.3s ease;
        animation: pulse 2s infinite; /* 添加脉冲动画 */
    }

    .nav-button.left {
        left: 1%;
    }

    .nav-button.right {
        right: 1%;
    }

    /* 悬停效果 */
    .nav-button:hover {
        background-color: rgba(255, 255, 255, 0.8);
        color: #000;
        transform: translateY(-50%) scale(1.1); /* 放大 */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        animation: bounce 0.5s; /* 悬停时触发弹跳动画 */
    }

    /* 脉冲动画效果 */
    @keyframes pulse {
        0% { transform: translateY(-50%) scale(1); }
        50% { transform: translateY(-50%) scale(1.05); }
        100% { transform: translateY(-50%) scale(1); }
    }

    /* 弹跳动画效果 */
    @keyframes bounce {
        0%, 100% { transform: translateY(-50%) scale(1.1); }
        50% { transform: translateY(-45%) scale(1.2); }
    }
</style>


<!-- 背景图片轮播 -->
<div class="background-slideshow">
    <img src="<?= Yii::getAlias('@web') ?>/images/背景图片1.jpg" class="active">
    <img src="<?= Yii::getAlias('@web') ?>/images/背景图片2.jpg">
    <img src="<?= Yii::getAlias('@web') ?>/images/背景图片3.jpg">
</div>

<div class="video-container">
    <!-- 左侧视频 -->
    <div class="video-item video-left" onclick="navigate(<?= $prevIndex ?>)">
        <video src="<?= $prevVideo ?>" muted loop></video>
    </div>

    <!-- 中间视频 -->
    <div class="video-item video-center">
        <video id="center-video" src="<?= $currentVideo ?>" controls autoplay></video>
    </div>

    <!-- 右侧视频 -->
    <div class="video-item video-right" onclick="navigate(<?= $nextIndex ?>)">
        <video src="<?= $nextVideo ?>" muted loop></video>
    </div>

    <!-- 导航按钮 -->
    <button class="nav-button left" onclick="navigate(<?= $prevIndex ?>)">&laquo;</button>
    <button class="nav-button right" onclick="navigate(<?= $nextIndex ?>)">&raquo;</button>
</div>

<script>
    function navigate(index) {
        window.location.href = '?index=' + index;
    }
</script>
