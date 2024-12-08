<?php
/* @var $this yii\web\View */
/* @var $tools backend\models\AllAiTool[] */
/* @var $pagination yii\data\Pagination */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'AI Tool Management';
?>

<div class="tool-management">
    <h1><?= Html::encode($this->title) ?></h1>

    <h3>All AI Tools</h3>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>AI Tool Name</th>
                <th>Description</th>
                <th>Free/Paid/Other</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tools as $tool): ?>
                <tr>
                    <td><?= Html::encode($tool->getAiToolName()) ?></td>
                    <td><?= Html::encode($tool->Description) ?></td>
                    <td><?= Html::encode($tool->getFreePaidOther()) ?></td>
                    <td>
                    <?= Html::a('Delete', ['delete-tool', 'toolName' => $tool->getAiToolName()], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this AI tool?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- 分页控件 -->
    <div class="pagination">
        <?= LinkPager::widget([
            'pagination' => $pagination,
        ]) ?>
    </div>

    <p>
        <?= Html::a('Add Tool', ['add-tool'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
