<?php
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117 庞艾语 2211581
 * 后端查看tool页面
*/
/* @var $this yii\web\View */
/* @var $tools backend\models\AllAiTool[] */
/* @var $pagination yii\data\Pagination */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'AI Tool Likes';
?>
<h1><?= Html::encode($this->title) ?></h1>

<!-- AI Tool 列表 -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>AI Tool Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($tools)): ?>
            <tr>
                <td colspan="3">No AI Tools found.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($tools as $tool): ?>
                <tr>
                    <!-- 显示工具名称 -->
                    <td><?= Html::encode($tool->getAttribute('AI Tool Name')) ?></td>
                    <td><?= Html::encode($tool->Description) ?></td>
                    <td>
                        <!-- View Likes 按钮 -->
                        <?= Html::a('View Likes', ['view-likes', 'toolName' => $tool->getAttribute('AI Tool Name')], [
                            'class' => 'btn btn-primary',
                        ]) ?>
                    </td>
                    <td>
                                                <!-- View Dislikes 按钮 -->
                        <?= Html::a('View Dislikes', ['view-dislikes', 'toolName' => $tool->getAttribute('AI Tool Name')], [
                            'class' => 'btn btn-danger',
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<!-- 分页控件 -->
<?= LinkPager::widget([
    'pagination' => $pagination,
]) ?>