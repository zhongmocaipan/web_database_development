<?php
use yii\helpers\Html;
/**
 * Team:LOVEYII,NKU
 * coding by 刘芳宜 2213925,20241218
 * This is the main layout of frontend web.
 */
/* @var $this yii\web\View */

$this->title = 'Dashboard';  // 页面标题
?>
<div class="site-dashboard">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Welcome to your dashboard, <?= Yii::$app->user->identity->username ?>!</p>

    <!-- 你可以在这里添加更多的信息和管理功能 -->
    <p>This is the user dashboard page where you can manage your account and view statistics.</p>
</div>
