<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->registerCssFile('@web/css/style.css');
?>

<h1>Movie Details by Douban ID</h1>

<!-- 搜索框 -->
<div class="search-form">
    <?php $form = ActiveForm::begin([
        'id' => 'search-form',
        'method' => 'get',
        'action' => '',
        'options' => ['class' => 'form-inline', 'data-pjax' => 1]
    ]); ?>
    
    <div class="form-group">
        <label for="douban-id-search" class="sr-only">Search by Douban ID:</label>
        <!-- 保持搜索框的值为当前搜索条件 -->
        <input type="text" id="douban-id-search" name="douban_id" class="form-control" 
               placeholder="Enter Douban ID" value="<?= Html::encode($searchTerm ?? '') ?>">
    </div>
    
    <?php ActiveForm::end(); ?>
</div>

<?php
// 获取搜索条件
$searchTerm = isset($_GET['douban_id']) ? $_GET['douban_id'] : null;

// 筛选匹配的电影
if ($searchTerm) {
    $filteredMovies = array_filter($movies, function($movie) use ($searchTerm) {
        return stripos($movie['douban_id'], $searchTerm) !== false; // 模糊匹配
    });
} else {
    $filteredMovies = $movies; // 如果没有搜索条件，则显示所有电影
}
?>

<div id="movie-list" class="row">
    <?php if ($filteredMovies): ?>
        <?php foreach ($filteredMovies as $movie): ?>
            <div class="col-lg-4">
                <div class="movie-box">
                    <h3>Douban ID: <?= Html::encode($movie['douban_id']) ?></h3>
                    <p><strong>Title:</strong> <?= Html::encode($movie['title']) ?></p>
                    <p><strong>Directors:</strong> <?= Html::encode($movie['directors']) ?></p>
                    <p><strong>Scriptwriters:</strong> <?= Html::encode($movie['scriptwriters']) ?></p>
                    <p><strong>Actors:</strong> <?= Html::encode($movie['actors']) ?></p>
                    <p><strong>Types:</strong> <?= Html::encode($movie['types']) ?></p>
                    <p><strong>Release Region:</strong> <?= Html::encode($movie['release_region']) ?></p>
                    <!-- 评论点赞按钮 -->
                    <p></p><a class="btn btn-default" href="<?= Url::to(['site/comment', 'douban_id' => $movie['douban_id']]) ?>">Comments & Like</a></p>

                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No movies found for the search term: <?= Html::encode($searchTerm) ?>.</p>
    <?php endif; ?>
</div>

<?php
// 添加样式来调整搜索框和电影展示
$this->registerCss('
    .search-form {
        margin-bottom: 20px;
    }
    .search-form input {
        width: 250px;
        margin-right: 10px;
    }
    .search-form button {
        margin-top: 10px;
    }
    .movie-box {
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
        background-color: #f9f9f9;
    }
    .movie-box p {
        margin: 5px 0;
    }
');
?>

<?php
// 添加 JS 来实现 AJAX 实时搜索
$this->registerJs('
    $("#douban-id-search").on("input", function() {
        // 获取搜索框的值
        var searchTerm = $("#douban-id-search").val();
        
        // 使用 pjax 请求刷新电影列表，带上搜索条件
        $.pjax.reload({
            container: "#movie-list", // 刷新电影列表部分
            timeout: 5000, // 请求超时设置
            push: false, // 禁用浏览器历史记录更新
            replace: false, // 不替换当前历史记录
            data: {douban_id: searchTerm} // 传递搜索条件
        });
    });
');
?>
