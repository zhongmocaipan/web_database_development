<?php
/* @var $this yii\web\View */
/* @var $tools array 数据库中所有工具的数组 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<h1>AI 工具列表</h1>

<!-- 筛选工具状态 -->
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
                        <a class="btn btn-default" href="<?= Url::to(['site/toolcomment', 'tool_name' => $tool['AI Tool Name']]) ?>">评论 & 点赞</a>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
