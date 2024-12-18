<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

// 注册 CSS 样式
$this->registerCssFile('@web/css/style.css'); // 可选，用于加载外部 CSS 文件
?>

<h1>Arxiv Papers</h1>

<!-- 日期检索表单 -->
<div class="search-bar">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => Url::to(['site/arxiv']), // 指向当前路由
        'options' => ['class' => 'form-inline'],
    ]); ?>
    <?= Html::input('date', 'date', $searchDate, [
        'class' => 'form-control',
        'placeholder' => 'Search by date',
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
    <p>No papers available for the selected date.</p>
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
        height: 450px; /* 统一高度 */
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
        background-color: #f9f9f9;
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
