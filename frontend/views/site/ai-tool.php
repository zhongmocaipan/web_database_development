<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->title = 'AI 工具列表';
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title><?= Html::encode($this->title) ?></title>
    <style>
body {
    margin: 0;
    padding: 0;
    background-image: url("<?= Yii::getAlias('@web') ?>/images/background.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    font-family: Arial, sans-serif;
}

h1 {
    color: white;
    text-align: center; /* 标题居中 */
    margin-top: 20px;
}


.search-bar {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px; /* 设置组件之间的间距 */
    margin-bottom: 20px;
}

select {
    box-sizing: border-box;
    width: 180px; /* 设置宽度，确保显示完整 */
    padding: 6px 10px;
    font-size: 1em;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.btn-primary {
    padding: 6px 15px;
    font-size: 1em;
    background-color: #4e73df;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #2e59d9;
}


.row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center; /* 所有卡片在行内居中 */
    gap: 20px; /* 设置行内间距 */
    margin: 0 auto;
    padding: 0 10px; /* 增加两侧内边距，防止偏移 */
    box-sizing: border-box;
}
.col-lg-4 {
    flex: 0 0 calc(33.333% - 20px); /* 确保每行 3 列卡片，减去间距 */
    max-width: calc(33.333% - 20px);
    box-sizing: border-box;
    margin: 0; /* 去除额外 margin */
}

.tool-box {
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    padding: 20px;
    text-align: left;
    height: 350px; /* 统一高度 */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-sizing: border-box;
}
@media (max-width: 992px) {
    .col-lg-4 {
        flex: 0 0 calc(50% - 20px); /* 中等屏幕显示两列 */
        max-width: calc(50% - 20px);
    }
}

@media (max-width: 768px) {
    .col-lg-4 {
        flex: 0 0 calc(100% - 20px); /* 小屏幕显示一列 */
        max-width: calc(100% - 20px);
    }
}
    </style>
</head>
<body>
    <h1>AI 工具列表</h1>

<!-- 搜索栏 -->
<div class="search-bar">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => Url::to(['site/ai-tool']),
        'options' => ['class' => 'form-inline'],
    ]); ?>
    <?= Html::dropDownList('tool_status', $toolStatus, [
        'Free' => 'Free',
        'Paid' => 'Paid',
        'Freemium' => 'Freemium',
        'Contact for Pricing' => 'Contact for Pricing',
        'Free Trial' => 'Free Trail',
        'Other' => 'Other',
    ], ['class' => 'form-control', 'prompt' => '选择工具状态']) ?>
    <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
</div>

    <!-- 工具列表 -->
    <div class="row">
        <?php foreach ($tools as $tool): ?>
            <div class="col-lg-4">
                <div class="tool-box">
                    <h3><?= Html::encode($tool['AI Tool Name']) ?></h3>
                    <p><strong>描述：</strong> <?= Html::encode($tool['Description']) ?></p>
                    <p><strong>免费/付费：</strong> <?= Html::encode($tool['Free/Paid/Other']) ?></p>
                    <p><strong>适用领域：</strong> <?= Html::encode($tool['Useable For']) ?></p>
                    <a href="<?= Url::to(['site/toolcomment', 'tool_name' => $tool['AI Tool Name']]) ?>" class="btn btn-default">
                        评论 & 点赞
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
