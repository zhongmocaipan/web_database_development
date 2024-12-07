<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

// 连接数据库
$connection = Yii::$app->db;

// 获取用户输入的日期
$searchDate = Yii::$app->request->get('date', '');

// 根据日期查询 arxiv_papers 表
if ($searchDate) {
    $arxivPapers = $connection->createCommand('SELECT * FROM arxiv_papers WHERE published = :date')
        ->bindValue(':date', $searchDate)
        ->queryAll();
} else {
    $arxivPapers = $connection->createCommand('SELECT * FROM arxiv_papers')->queryAll();
}

$this->registerCssFile('@web/css/style.css');  // 引入样式文件
?>

<h1>Arxiv Papers</h1>

<!-- 日期检索框 -->
<div class="search-bar">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => Url::to(['site/arxiv']),
        'options' => ['class' => 'form-inline'],
    ]); ?>
    <?= Html::input('date', 'date', $searchDate, ['class' => 'form-control', 'placeholder' => 'Select date']) ?>
    <?= Html::submitButton('Search by Date', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
</div>

<!-- 显示所有论文 -->
<?php if ($arxivPapers): ?>
    <div class="row">
        <?php foreach ($arxivPapers as $paper): ?>
            <div class="col-lg-4">
                <div class="paper-box">
                    <p><strong>Title:</strong> <?= Html::encode($paper['title']) ?></p>
                    <p><strong>Abstract:</strong> 
                        <?php 
                        $abstractWords = explode(' ', $paper['abstract']);
                        $shortAbstract = implode(' ', array_slice($abstractWords, 0, 20)) . (count($abstractWords) > 20 ? '...' : '');
                        echo Html::encode($shortAbstract); 
                        ?>
                    </p>
                    <p><strong>Published Date:</strong> <?= Html::encode($paper['published']) ?></p>
                    <p><strong>Authors:</strong> <?= Html::encode($paper['authors']) ?></p>
                    <p><strong>URL:</strong> <a href="<?= Html::encode($paper['url']) ?>" target="_blank"><?= Html::encode($paper['url']) ?></a></p>
                    <p>
                        <a class="btn btn-default" href="<?= Url::to(['site/comment', 'paper_id' => $paper['id']]) ?>">Comments & Like</a>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No papers found for the selected date.</p>
<?php endif; ?>

<?php
// 添加样式来调整页面布局和背景图片
// 添加样式来调整页面布局和背景图片
$this->registerCss('
    body {
        background-image: url("' . Yii::getAlias('@web/images/background.jpg') . '");
        background-size: cover; /* 背景图像覆盖整个页面 */
        background-attachment: fixed; /* 背景固定不滚动 */
        background-position: center; /* 背景居中 */
        background-repeat: no-repeat; /* 不重复背景图片 */
        color: #333; /* 字体颜色，确保在背景上清晰可见 */
    }
    /* 修改标题样式 */
    h1 {
        font-size: 48px; /* 增加字号 */
        color: #f0f0f0; /* 设置浅色字体 */
        font-weight: bold; /* 加粗字体 */
        text-align: center; /* 居中对齐标题 */
        margin-top: 30px; /* 顶部留白 */
    }
    .search-bar {
        margin-bottom: 20px;
        text-align: center;
    }
    .search-bar .form-control {
        width: 300px;
        display: inline-block;
    }
    .paper-box {
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
        background-color: rgba(255, 255, 255, 0.9); /* 设置半透明背景，提升可读性 */
        min-height: 400px; /* 调整框的最小高度以适应所有内容 */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .paper-box p {
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
