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
// 注册样式
$this->registerCss('
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
        background-color: #f9f9f9;
        min-height: 400px; /* 调整框的最小高度 */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .paper-box p {
        margin: 5px 0;
    }
    .row {
        margin-top: 20px;
    }
');
?>
