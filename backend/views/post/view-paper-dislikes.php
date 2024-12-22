<?php
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端paper点赞页面
*/
/* @var $this yii\web\View */
/* @var $paperLikes backend\models\PaperLike[] */
/* @var $pagination yii\data\Pagination */
/* @var $paper backend\models\ArxivPaper */
/* @var $totalLikes int */

use yii\helpers\Html;
use common\models\User;  // 导入 User 模型

$this->title = 'Disikes for ' . Html::encode($paper->title);
$this->params['breadcrumbs'][] = ['label' => 'Papers', 'url' => ['papers/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="paper-dislikes">
    <h2>Paper Information</h2>
    <p><strong>Title:</strong> <?= Html::encode($paper->title) ?></p>
    <p><strong>Author:</strong> <?= Html::encode($paper->authors) ?></p>
    <p><strong>Published At:</strong> <?= Yii::$app->formatter->asDatetime($paper->published, 'php:Y-m-d') ?></p>

    <!-- 显示点赞总数 -->
    <p><strong>Total Dislikes:</strong> <?= Html::encode($totalDislikes) ?></p>

    <h2>Dislikes</h2>
    <?php if (empty($paperDislikes)): ?>
        <p>No dislikes yet for this paper.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paperDislikes as $paperDislike): ?>
                    <tr>
                        <!-- 显示点赞的用户 -->
                        <td>
                            <?php
                                // 获取点赞的用户信息
                                $user = User::findOne($paperDislike->user_id);
                                if ($user) {
                                    echo Html::encode($user->username);  // 显示用户名
                                } else {
                                    echo 'Unknown User';  // 如果没有找到用户，显示 "Unknown User"
                                }
                            ?>
                        </td>

                        <td><?= Yii::$app->formatter->asDatetime($paperDislike->created_at, 'php:Y-m-d H:i:s') ?></td>
                        <td>
                            <!-- 删除点赞按钮 -->
                            <?= Html::a('Delete', ['delete-paper-dislike', 'id' => $paperDislike->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this dislike?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- 分页 -->
    <div class="text-center">
        <?= yii\widgets\LinkPager::widget([
            'pagination' => $pagination,
        ]) ?>
    </div>
</div>
