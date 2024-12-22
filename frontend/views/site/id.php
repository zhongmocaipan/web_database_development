<?php
/**
 * Team:LOVEYII,NKU
 * coding by 刘芳宜 2213925,20241218 庞艾语 2211581，20241221
 * This is the main layout of frontend web.
 */
/* @var $this yii\web\View */
/* @var $tools array 数据库中所有工具的数组 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm; 
?>

<h1>AI 工具列表</h1>

<!-- 搜索栏 -->
<div class="search-bar">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => Url::to(['site/ai_tool']),
        'options' => ['class' => 'form-inline'],
    ]); ?>
    <?= Html::dropDownList('tool_status', null, [
        'Free' => 'Free',
        'Paid' => 'Paid',
        'Freemium' => 'Freemium',
        'Contact for Pricing' => 'Contact for Pricing',
        'Free Trial' => 'Free Trial',
        'Other' => 'Other'
    ], ['class' => 'form-control', 'prompt' => '选择工具状态']) ?>

    <?= Html::textInput('useableFor', null, ['class' => 'form-control', 'placeholder' => '输入适用领域']) ?>

    <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
</div>

<!-- 工具列表 -->
<?php if (empty($tools)): ?>
    <p>没有找到任何工具。</p>
<?php else: ?>
    <div class="row">
        <?php foreach ($tools as $tool): ?>
            <div class="col-lg-4">
                <div class="paper-box">
                    <h3><?= Html::encode($tool['AI Tool Name']) ?></h3>
                    <p><strong>描述：</strong> <?= Html::encode($tool['Description']) ?></p>
                    <p><strong>免费/付费：</strong> <?= Html::encode($tool['Free/Paid/Other']) ?></p>
                    <p><strong>适用领域：</strong> <?= Html::encode($tool['Useable For']) ?></p>
                    <p>
                        <!-- 添加评论按钮，点击后跳转到评论页面 -->
                        <a class="btn btn-default" href="<?= Url::to(['site/toolcomment', 'tool_name' => $tool['AI Tool Name']]) ?>">Interactions</a>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
// 注册样式
$this->registerCss('
    body {
            background-image: url("' . Yii::getAlias('@web/images/background.jpg') . '");
            background-size: cover; /* 背景图像覆盖整个页面 */
            background-attachment: fixed; /* 背景固定不滚动 */
            background-position: center; /* 背景居中 */
            background-repeat: no-repeat; /* 不重复背景图片 */
            color: #333; /* 字体颜色，确保在背景上清晰可见 */
        }
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
        background-color: rgba(255, 255, 255, 0.9);
        min-height: 400px; /* 调整框的最小高度 */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .paper-box h3 {
        color: #4e73df;
    }
    .paper-box p {
        margin: 5px 0;
    }
    .row {
        margin-top: 20px;
    }
');
?>