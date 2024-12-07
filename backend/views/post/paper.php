<?php
/* @var $this yii\web\View */
/* @var $papers backend\models\ArxivPaper[] */
/* @var $pagination yii\data\Pagination */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Papers Management';
?>

<h1><?= Html::encode($this->title) ?></h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Paper Title</th>
            <th>Author</th>
            <th>Published At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($papers as $paper): ?>
            <tr>
                <td><?= Html::encode($paper->title) ?></td>
                <td><?= Html::encode($paper->authors) ?></td>
                <td><?= Yii::$app->formatter->asDatetime($paper->published, 'php:Y-m-d') ?></td>
                <td>
                    <!-- 查看评论按钮 -->

                    <?= Html::a('View Likes', ['post/view-paper-likes', 'id' => $paper->id], ['class' => 'btn btn-primary']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- 分页控件 -->
<?= LinkPager::widget([
    'pagination' => $pagination,
]) ?>
