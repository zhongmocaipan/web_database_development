<?php
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端查看paper页面
*/
/* @var $this yii\web\View */
/* @var $paper backend\models\ArxivPaper */
/* @var $comments backend\models\Comment[] */

use yii\helpers\Html;
use common\models\User;  // 导入 User 模型

$this->title = 'Comments for Paper: ' . Html::encode($paper->title);
$this->params['breadcrumbs'][] = ['label' => 'Papers', 'url' => ['paper']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="paper-comments">
    <h2>Paper Information</h2>
    <p><strong>Title:</strong> <?= Html::encode($paper->title) ?></p>
    <p><strong>Authors:</strong> <?= Html::encode($paper->authors) ?></p>
    <p><strong>Abstract:</strong> <?= Html::encode($paper->abstract) ?></p>
    <p><strong>Published Date:</strong> <?= Yii::$app->formatter->asDatetime($paper->published, 'php:Y-m-d') ?></p>

    <h2>Comments</h2>
    <?php if (empty($comments)): ?>
        <p>No comments yet for this paper.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Comment</th>
                    <th>User</th> <!-- 添加用户信息列 -->
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $comment): ?>
                    <tr>
                        <td><?= Html::encode($comment->content) ?></td>

                        <!-- 显示评论的用户 -->
                        <td>
                            <?php 
                                // 获取评论的用户信息
                                $user = User::findOne($comment->user_id); 
                                if ($user) {
                                    echo Html::encode($user->username);  // 显示用户名
                                } else {
                                    echo 'Unknown User';  // 如果没有找到用户，显示为 "Unknown User"
                                }
                            ?>
                        </td>

                        <td><?= Yii::$app->formatter->asDatetime($comment->created_at, 'php:Y-m-d H:i:s') ?></td>
                        <td>
                            <!-- 编辑评论按钮 -->
                            <?= Html::a('Edit', ['comment/update-paper-comment', 'id' => $comment->id], ['class' => 'btn btn-warning']) ?>

                            <!-- 删除评论按钮 -->
                            <?= Html::a('Delete', ['comment/delete-paper-comment', 'id' => $comment->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this comment?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
