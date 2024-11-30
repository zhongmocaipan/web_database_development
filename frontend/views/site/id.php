<?php
use yii\helpers\Html;

// 引入公共 CSS 文件
$this->registerCssFile('@web/css/style.css');
?>

<h1>Movie Details by Douban ID</h1>

<div class="row">
    <?php foreach ($movies as $movie): ?>
        <div class="col-lg-4">
            <div class="movie-box">
                <h3>Douban ID: <?= Html::encode($movie['douban_id']) ?></h3>
                <p><strong>Title:</strong> <?= Html::encode($movie['title']) ?></p>
                <p><strong>Directors:</strong> <?= Html::encode($movie['directors']) ?></p>
                <p><strong>Scriptwriters:</strong> <?= Html::encode($movie['scriptwriters']) ?></p>
                <p><strong>Actors:</strong> <?= Html::encode($movie['actors']) ?></p>
                <p><strong>Types:</strong> <?= Html::encode($movie['types']) ?></p>
                <p><strong>Release Region:</strong> <?= Html::encode($movie['release_region']) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
