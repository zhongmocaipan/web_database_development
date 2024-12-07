<?php
/* @var $this yii\web\View */
/* @var $tool backend\models\AllAiTool */
/* @var $comments backend\models\ToolComment[] */

use yii\helpers\Html;
use common\models\User;  // 导入 User 模型

$this->title = 'Comments for ' . Html::encode($tool->getAttribute('AI Tool Name'));
$this->params['breadcrumbs'][] = ['label' => 'AI Tools', 'url' => ['ai-tool']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="tool-comments">
    <h2>Tool Information</h2>
    <p><strong>Tool Name:</strong> <?= Html::encode($tool->getAttribute('AI Tool Name')) ?></p>
    <p><strong>Description:</strong> <?= Html::encode($tool->Description) ?></p>

    <h2>Comments</h2>
    <?php if (empty($comments)): ?>
        <p>No comments yet for this tool.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Comment</th>
                    <th>User</th> <!-- 添加一个列显示用户 -->
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
                            <?= Html::a('Edit', ['comment/update-comment', 'id' => $comment->id], ['class' => 'btn btn-warning']) ?>

                            <!-- 删除评论按钮 -->
                            <?= Html::a('Delete', ['delete-comment', 'id' => $comment->id], [
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
