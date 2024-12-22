<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
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
    <?php $this->head() ?>

    <style>
        /* 背景图片轮播样式 */
        .background-slideshow {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; /* 确保背景图在其他内容后面 */
            overflow: hidden;
        }

        .background-slideshow img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* 确保图片覆盖整个区域 */
            opacity: 0;
            animation: fadeInOut 15s infinite; /* 轮播动画 */
        }

        .background-slideshow img.active {
            opacity: 1;
        }

        /* 轮播动画，图片渐变效果 */
        @keyframes fadeInOut {
            0%, 100% {
                opacity: 0;
            }
            10%, 90% {
                opacity: 1;
            }
        }

        /* 可以添加更多图片的显示规则 */
        .background-slideshow img:nth-child(2) {
            animation-delay: 5s; /* 第二张图片延迟出现 */
        }

        .background-slideshow img:nth-child(3) {
            animation-delay: 10s; /* 第三张图片延迟出现 */
        }

    </style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php if (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index' || 
          Yii::$app->controller->id == 'post' && Yii::$app->controller->action->id == 'select-type'||
          Yii::$app->controller->id == 'comment' && Yii::$app->controller->action->id == 'select-type')
          : ?>
   <!-- 背景图片轮播 -->
   <div class="background-slideshow">
       <img src="<?= Yii::getAlias('@web') ?>/images/背景图片1.jpg" class="active">
       <img src="<?= Yii::getAlias('@web') ?>/images/背景图片2.jpg">
       <img src="<?= Yii::getAlias('@web') ?>/images/背景图片3.jpg">
   </div>
<?php endif; ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
