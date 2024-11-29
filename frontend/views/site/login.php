<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
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
        background-color: #000;
        overflow: hidden;
    }

    .site-login {
        position: relative;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 2;
    }

    .login-container {
        background-color: rgba(255, 255, 255, 0.8);
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        max-width: 400px;
        width: 100%;
        text-align: center;
    }

    .login-container h1 {
        font-size: 36px;
        color: #fff;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border-radius: 5px;
    }

    .btn-primary:hover {
        background-color: #3e63c9;
        border-color: #3e63c9;
    }

    .form-group a {
        color: #4e73df;
        font-size: 14px;
    }

    .form-group a:hover {
        text-decoration: underline;
    }

    .text-center {
        color: #fff;
        font-size: 14px;
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
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
        transition: opacity 1s ease-in-out;
    }

    .background-slideshow img.active {
        opacity: 1;
    }
</style>

<div class="site-login">
    <div class="login-container">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Please fill out the following fields to login:</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Username']) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']) ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div class="form-group text-center">
            <div style="color:#999;margin:1em 0">
                If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                <br>
                Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <!-- Background Image Slideshow -->
    <div class="background-slideshow">
        <img src="<?= Yii::getAlias('@web') ?>/assets/images/背景图片.jpg" class="active">
        <img src="<?= Yii::getAlias('@web') ?>/images/背景图片.jpg">
        <img src="<?= Yii::getAlias('@web') ?>/images/背景图片.jpg">
    </div>
</div>

<script>
    // 图片轮播效果
    let currentImageIndex = 0;
    const images = document.querySelectorAll('.background-slideshow img');
    const totalImages = images.length;

    setInterval(() => {
        // 移除当前图片的active类
        images[currentImageIndex].classList.remove('active');

        // 切换到下一个图片
        currentImageIndex = (currentImageIndex + 1) % totalImages;

        // 为下一个图片添加active类
        images[currentImageIndex].classList.add('active');
    }, 5000); // 每5秒切换一次图片
</script>

