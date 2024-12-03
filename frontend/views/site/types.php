<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

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

                        <!-- 评论点赞按钮 -->
                        <p></p><a class="btn btn-default" href="<?= Url::to(['site/comment', 'douban_id' => $movie['douban_id']]) ?>">Comments & Like</a></p>




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
        background-color: rgb(178 230 193 / 79%);
        z-index: 1000;
        padding: 10px 0;
        opacity: 0; /* 初始透明，导航栏不可见 */
        transition: opacity 0.3s ease-in-out; /* 平滑过渡 */
    }
    .movie-types-nav.show {
        opacity: 1; /* 鼠标悬停时显示导航栏 */
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
        color: #000;  /* 初始字体颜色为黑色 */
        text-decoration: none;
        padding: 10px 20px;
        background-color: transparent; /* 背景透明 */
        border-radius: 5px;
        transition: color 0.3s ease, background-color 0.3s ease; /* 平滑过渡 */
    }
    .movie-types-nav ul li a:hover {
        color: #ff0000;  /* 鼠标悬停时字体颜色为红色 */
        background-color: rgba(255, 0, 0, 0.1); /* 可选：鼠标悬停时添加淡红色背景 */
    }
    .row {
        margin-top: 60px; /* 给固定导航条留出空间 */
    }
');
?>

<script>
    const nav = document.querySelector('.movie-types-nav');

    // 当鼠标进入导航栏区域时，显示导航栏
    nav.addEventListener('mouseenter', function() {
        nav.classList.add('show');
    });

    // 当鼠标离开导航栏区域时，隐藏导航栏
    nav.addEventListener('mouseleave', function() {
        nav.classList.remove('show');
    });

    // 当鼠标离开整个页面时，隐藏导航栏
    window.addEventListener('mouseleave', function() {
        nav.classList.remove('show');
    });
</script>
