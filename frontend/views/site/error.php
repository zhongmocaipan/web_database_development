<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<!-- 页面样式 -->
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Arial', sans-serif;
        color: #fff;
        background: #111;
        overflow: hidden;
    }

    /* 动态粒子背景 */
    #particles-js {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
    }

    .error-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        text-align: center;
    }

    .error-icon {
        font-size: 6rem;
        color: #e74c3c;
        margin-bottom: 20px;
        animation: pulse 1.5s infinite;
    }

    .error-title {
        font-size: 2.5rem;
        margin: 10px 0;
        color: #f5f5f5;
    }

    .error-message {
        font-size: 1.2rem;
        margin: 15px 0;
        color: #bdc3c7;
    }

    .error-container a {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        font-size: 1rem;
        color: #fff;
        background-color: #3498db;
        border-radius: 5px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .error-container a:hover {
        background-color: #2980b9;
        transform: scale(1.1);
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }
</style>

<!-- 动态粒子背景 -->
<div id="particles-js"></div>

<!-- 错误页面内容 -->
<div class="error-container">
    <div class="error-icon">
        &#9888;
    </div>
    <div class="error-title">
        <?= Html::encode($this->title) ?>
    </div>
    <div class="error-message">
        <?= nl2br(Html::encode($message)) ?>
    </div>
    <p>
        Something went wrong. Please <strong>contact us</strong> if the issue persists.
    </p>
    <a href="javascript:void(0);" onclick="history.back();">Return to Previous Page</a>
    </div>

<!-- 引入粒子效果脚本 -->
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script>
    particlesJS("particles-js", {
        "particles": {
            "number": { "value": 100, "density": { "enable": true, "value_area": 800 } },
            "color": { "value": "#ffffff" },
            "shape": { "type": "circle" },
            "opacity": {
                "value": 0.5,
                "random": false,
                "anim": { "enable": false }
            },
            "size": {
                "value": 3,
                "random": true,
                "anim": { "enable": false }
            },
            "line_linked": {
                "enable": true,
                "distance": 150,
                "color": "#ffffff",
                "opacity": 0.4,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 6,
                "direction": "none",
                "random": false,
                "straight": false,
                "out_mode": "out",
                "bounce": false
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": { "enable": true, "mode": "repulse" },
                "onclick": { "enable": true, "mode": "push" }
            },
            "modes": {
                "repulse": { "distance": 100, "duration": 0.4 },
                "push": { "particles_nb": 4 }
            }
        },
        "retina_detect": true
    });
</script>
