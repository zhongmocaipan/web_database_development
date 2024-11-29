<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model frontend\models\ContactForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Contact';
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

    .site-contact {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 2;
        height: 100%;
        text-align: center;
        padding: 20px;
    }

    .contact-container {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        max-width: 600px;
        width: 100%;
        text-align: center;
    }

    .contact-container h1 {
        font-size: 24px;
        color: #4e73df;
        margin-bottom: 20px;
    }

    .contact-container p {
        font-size: 16px;
        color: #333;
        margin-bottom: 20px;
    }

    .form-group label {
        font-size: 14px;
        color: #4e73df;
        font-weight: bold;
    }

    .form-control {
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .btn-primary {
        background-color: #4e73df;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #3b5ebf;
    }
</style>

<div class="site-contact">
    <div class="contact-container">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            We'd love to hear from you! Please fill out the form below to get in touch with us.
        </p>

        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

        <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'placeholder' => 'Your Name'])->label(false) ?>

        <?= $form->field($model, 'email')->textInput(['placeholder' => 'Your Email'])->label(false) ?>

        <?= $form->field($model, 'subject')->textInput(['placeholder' => 'Subject'])->label(false) ?>

        <?= $form->field($model, 'body')->textarea(['rows' => 6, 'placeholder' => 'Your Message'])->label(false) ?>



        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>



</div>

<!-- 背景图片轮播 -->
<div class="background-slideshow">
    <img src="<?= Yii::getAlias('@web') ?>/assets/images/contact1.jpg" class="active">
    <img src="<?= Yii::getAlias('@web') ?>/assets/images/contact2.jpg">
    <img src="<?= Yii::getAlias('@web') ?>/assets/images/contact3.jpg">
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