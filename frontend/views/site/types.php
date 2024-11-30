<?php
use yii\helpers\Html;

$this->registerCssFile('@web/css/style.css');  // 引入样式文件
?>

<h1>Movies by Types</h1>

<!-- 电影类型按钮，固定在页面顶部 -->
<div class="movie-types-nav">
    <ul>
        <?php foreach ($movieTypes as $type => $movies): ?>
            <li><a href="#<?= Html::encode($type) ?>" class="btn btn-primary"><?= Html::encode($type) ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="row">
    <?php foreach ($movieTypes as $type => $movies): ?>
        <div class="col-lg-12" id="<?= Html::encode($type) ?>"> <!-- 为每个类型生成一个 ID 方便跳转 -->
            <h2><?= Html::encode($type) ?></h2>  <!-- 显示电影类型 -->

            <div class="movie-list">
                <?php foreach ($movies as $movie): ?>
                    <div class="movie-box">
                        <p><strong>Title:</strong> <?= Html::encode($movie['title']) ?></p>
                        <p><strong>Directors:</strong> <?= Html::encode($movie['directors']) ?></p>
                        <p><strong>Actors:</strong> <?= Html::encode($movie['actors']) ?></p>
                        <p><strong>Types:</strong> <?= Html::encode($movie['types']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
// 添加样式来固定按钮和调整布局
$this->registerCss('
    .movie-types-nav {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 1000;
        padding: 10px 0;
    }
    .movie-types-nav ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        text-align: center;
    }
    .movie-types-nav ul li {
        display: inline;
        margin: 0 10px;
    }
    .movie-types-nav ul li a {
        color: #fff;
        text-decoration: none;
        padding: 10px 20px;
        background-color: #007bff;
        border-radius: 5px;
    }
    .movie-types-nav ul li a:hover {
        background-color: #0056b3;
    }
    .row {
        margin-top: 60px; /* 给固定导航条留出空间 */
    }
');
?>
