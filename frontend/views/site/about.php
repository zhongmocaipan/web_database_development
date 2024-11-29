<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
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

    .site-about {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 2;
        height: 100%;
        text-align: center;
        padding: 20px;
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
    text-align: center; /* 将内容居中对齐 */
}

    .features h2 {
    font-size: 24px;
    color: #4e73df;
    margin-bottom: 15px;
}

    .features ul {
    list-style: none;
    padding-left: 0;
    display: inline-block; /* 让列表居中 */
    text-align: left; /* 列表项内容保持左对齐 */
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


</style>

<div class="site-about">
    <div class="about-container">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            Welcome to Movie Review Hub! A platform designed for movie enthusiasts to explore, review, and discuss films. Our goal is to create an engaging community for sharing your thoughts and discovering hidden cinematic gems.
        </p>

        <div class="features">
            <h2>Key Features</h2>
            <ul>
                <li>Post and read detailed movie reviews from users worldwide.</li>
                <li>Personalized recommendations based on your viewing history.</li>
                <li>Follow your favorite reviewers and interact with their posts.</li>
                <li>Create and manage your watchlist effortlessly.</li>
                <li>Explore trending movies and critically acclaimed classics.</li>
            </ul>
        </div>

        <div class="team">
            <h2>Meet the Team</h2>
            <div class="team-member">
                <img src="<?= Yii::getAlias('@web') ?>/assets/images/team1.jpg" alt="Team Member">
                <span>Jane Doe</span>
                <p>Founder & CEO</p>
                <p>Jane is a film enthusiast and entrepreneur dedicated to creating the best movie review platform.</p>
            </div>
            <div class="team-member">
                <img src="<?= Yii::getAlias('@web') ?>/assets/images/team2.jpg" alt="Team Member">
                <span>John Smith</span>
                <p>CTO</p>
                <p>John is the technical genius behind the platform, ensuring a seamless user experience.</p>
            </div>
            <div class="team-member">
                <img src="<?= Yii::getAlias('@web') ?>/assets/images/team3.jpg" alt="Team Member">
                <span>Mary Johnson</span>
                <p>Head of Design</p>
                <p>Mary brings the platform to life with her innovative and user-friendly designs.</p>
            </div>
        </div>
    </div>
</div>

<!-- 背景图片轮播 -->
<div class="background-slideshow">
    <img src="<?= Yii::getAlias('@web') ?>/assets/images/movie1.jpg" class="active">
    <img src="<?= Yii::getAlias('@web') ?>/assets/images/movie2.jpg">
    <img src="<?= Yii::getAlias('@web') ?>/assets/images/movie3.jpg">
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