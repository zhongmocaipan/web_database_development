<?php
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端登陆页面
*/
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\LoginFormAdministor */  

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

    /* 页面布局 */
    .site-login {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 2;
        height: 80vh; /* 使其高度占满整个视口 */
    }

    /* 登录框样式 */
    .login-container {
        background-color: rgba(255, 255, 255, 0.8); /* 半透明背景 */
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        max-width: 400px;
        width: 100%;
        text-align: center;
    }

    .login-container h1 {
        font-size: 36px;
        color: #4e73df;
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
</style>

<div class="site-login">
    <div class="login-container">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Please fill out the following fields to login:</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <!-- 用户名输入框 -->
        <?= $form->field($model, 'administorname')->textInput(['autofocus' => true, 'placeholder' => 'Username'])->label(false) ?>

        <!-- 密码输入框 -->
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>

        <!-- 记住我复选框 -->
        <?= $form->field($model, 'rememberMe')->checkbox()->label('Remember Me') ?>

        <div class="form-group">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

