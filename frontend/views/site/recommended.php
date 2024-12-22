<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/**
 * Team:LOVEYII,NKU
 * coding by 刘芳宜 2213925,20241218 庞艾语 2211581，20241220
 * This is the main layout of frontend web.
 */
// 连接数据库
$connection = Yii::$app->db;

// 获取用户输入的日期
$startDate = Yii::$app->request->get('start_date', '');
$endDate = Yii::$app->request->get('end_date', '');

// 根据日期查询 arxiv_papers 表
if ($startDate && $endDate) {
    $arxivPapers = $connection->createCommand('SELECT * FROM arxiv_papers WHERE published BETWEEN :start_date AND :end_date')
        ->bindValue(':start_date', $startDate)
        ->bindValue(':end_date', $endDate)
        ->queryAll();
} else {
    $arxivPapers = $connection->createCommand('SELECT * FROM arxiv_papers')->queryAll();
}

$this->registerCssFile('@web/css/style.css');  // 引入样式文件
?>

<h1>AI 论文列表</h1>

<!-- 日期检索表单 -->
<div class="search-bar">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => Url::to(['site/arxiv']), // 指向当前路由
        'options' => ['class' => 'form-inline'],
    ]); ?>
    <label for="start_date" style="color: white;">Start Date:</label>
    <?= Html::input('date', 'start_date', $startDate, [
        'class' => 'form-control',
        'placeholder' => 'Start Date',
    ]) ?>
    <label for="end_date" style="color: white;">End Date:</label>
    <?= Html::input('date', 'end_date', $endDate, [
        'class' => 'form-control',
        'placeholder' => 'End Date',
    ]) ?>
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
</div>

<!-- 显示论文列表 -->
<?php if (!empty($arxivPapers)): ?>
    <div class="row">
        <?php foreach ($arxivPapers as $paper): ?>
            <div class="col-lg-4">
                <div class="paper-box">
                    <p><strong>标题:</strong> <?= Html::encode($paper['title']) ?></p>
                    <p><strong>摘要:</strong> 
                        <?php 
                        $abstractWords = explode(' ', $paper['abstract']);
                        $shortAbstract = implode(' ', array_slice($abstractWords, 0, 20)) . (count($abstractWords) > 20 ? '...' : '');
                        echo Html::encode($shortAbstract); 
                        ?>
                    </p>
                    <p><strong>发表时间:</strong> <?= Html::encode($paper['published']) ?></p>
                    <p><strong>作者:</strong> <?= Html::encode($paper['authors']) ?></p>
                    <p><strong>URL:</strong> <a href="<?= Html::encode($paper['url']) ?>" target="_blank"><?= Html::encode($paper['url']) ?></a></p>
                    <p>
                        <a class="btn btn-default" href="<?= Url::to(['site/comment', 'paper_id' => $paper['id']]) ?>">Interactions</a>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No papers available for the selected date range.</p>
<?php endif; ?>

<?php
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
        box-shadow: 0 4px 8px rgba(0,0,0,0.2); /* 添加阴影美化 */
    }
    .paper-box p {
        margin: 5px 0;
        flex: 1; /* 自动填充空间 */
    }
    .row {
        margin-top: 20px;
    }
');
?>