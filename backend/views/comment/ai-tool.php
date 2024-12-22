<?php
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端评论tool页面
*/
/* @var $this yii\web\View */
/* @var $tools backend\models\AllAiTool[] */
/* @var $pagination yii\data\Pagination */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'AI Tool Comments';
?>

<h1><?= Html::encode($this->title) ?></h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>AI Tool Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tools as $tool): ?>
            <tr>
                <!-- 使用 getAttribute() 获取 AI Tool Name -->
                <td><?= Html::encode($tool->getAttribute('AI Tool Name')) ?></td>
                <td><?= Html::encode($tool->Description) ?></td>
                <!-- <td>
                    <?= Html::a('Delete', ['delete-comment', 'toolName' => $tool->getAttribute('AI Tool Name')], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this comment?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </td> -->
                <td>
                    <?= Html::a('View Comments', ['view-comments', 'toolName' => $tool->getAttribute('AI Tool Name')], [
                        'class' => 'btn btn-primary',
                    ]) ?>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- 分页控件 -->
<?= LinkPager::widget([
    'pagination' => $pagination,
]) ?>
