<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


$this->registerCssFile('@web/css/style.css');  // 引入样式文件
?>

<h1>Recommended Movies by Release Region</h1>

<!-- 固定头部下拉列表 -->
<div class="movie-regions-nav">
    <form method="get" action="">
        <div class="form-group">
            <label for="region-select">Select Release Region:</label>
            <select id="region-select" name="region" class="form-control" onchange="this.form.submit()">
                <option value="">-- Select a Region --</option>
                <?php foreach ($regionsList as $region): ?>
                    <option value="<?= Html::encode($region) ?>" <?= isset($_GET['region']) && $_GET['region'] == $region ? 'selected' : '' ?>>
                        <?= Html::encode($region) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
</div>

<?php
// 根据选择的发行地区筛选电影
$selectedRegion = isset($_GET['region']) ? $_GET['region'] : null;
$filteredMovies = $selectedRegion ? $movieRegions[$selectedRegion] : [];

if ($filteredMovies): ?>
    <div class="row">
        <h2>Movies in <?= Html::encode($selectedRegion) ?> Region</h2>
        <?php foreach ($filteredMovies as $movie): ?>
            <div class="col-lg-3">
                <div class="movie-box">
                    <p><strong>Title:</strong> <?= Html::encode($movie['title']) ?></p>
                    <p><strong>Directors:</strong> <?= Html::encode($movie['directors']) ?></p>
                    <p><strong>Actors:</strong> <?= Html::encode($movie['actors']) ?></p>
                    <p><strong>Release Region:</strong> <?= Html::encode($movie['release_region']) ?></p>

                    <!-- 评论点赞按钮 -->
                    <p></p><a class="btn btn-default" href="<?= Url::to(['site/comment', 'douban_id' => $movie['douban_id']]) ?>">Comments & Like</a></p>



                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No movies available for the selected region.</p>
<?php endif; ?>

<?php
// 添加样式来调整电影推荐页面的布局
$this->registerCss('
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
    .movie-regions-nav {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: rgb(0 0 0 / 0%);
        z-index: 1000;
        padding: 10px 0;
    }
    .movie-regions-nav form {
        margin: 0;
        padding: 0 20px;
        position: relative; 
        top: 20px; /* 上下偏移 */
        left: 0px; /* 左右偏移 */
    }
    .movie-regions-nav select {
        width: 200px;
        background-color: #f0f0f0; /* 设置下拉框的背景颜色 */
        border: 1px solid #ccc; /* 可以自定义边框颜色 */
        padding: 5px; /* 添加内边距，使下拉框内容不紧挨边缘 */
        border-radius: 5px; /* 边角圆润 */
        z-index: 1001; /* 设置下拉框的 z-index，确保它在导航栏上方 */
    }
    .movie-regions-nav select {
        width: 200px;
        background-color: #f0f0f0; /* 设置下拉框的背景颜色 */
        border: 1px solid #ccc; /* 可以自定义边框颜色 */
        padding: 5px; /* 添加内边距，使下拉框内容不紧挨边缘 */
        border-radius: 5px; /* 边角圆润 */
        height: 30px; /* 设置下拉框的高度 */
        line-height: 30px; /* 设置文本的垂直对齐，避免文本显得偏高或偏低 */
        z-index: 1001; /* 设置下拉框的 z-index，确保它在导航栏上方 */
    }
        
    .movie-regions-nav select:focus {
        background-color: #e6e6e6; /* 设置获得焦点时的背景颜色 */
        border-color: #007bff; /* 设置聚焦时的边框颜色 */
    }
    .row {
        margin-top: 60px; /* 给固定导航条留出空间 */
    }
');
?>