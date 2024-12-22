<?php
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端查看tool点赞页面
*/
/* @var $this yii\web\View */
/* @var $toolLikes backend\models\ToolLike[] */
/* @var $pagination yii\data\Pagination */
/* @var $tool backend\models\AllAiTool */

use yii\helpers\Html;
use common\models\User;  // 导入 User 模型

$this->title = 'Dislikes for ' . Html::encode($tool->getAttribute('AI Tool Name'));
$this->params['breadcrumbs'][] = ['label' => 'AI Tools', 'url' => ['ai-tool']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="tool-dislikes">
    <h2>Tool Information</h2>
    <p><strong>Tool Name:</strong> <?= Html::encode($tool->getAttribute('AI Tool Name')) ?></p>
    <p><strong>Description:</strong> <?= Html::encode($tool->Description) ?></p>

    <!-- 显示点赞总数 -->
    <p><strong>Total Dislikes:</strong> <?= Html::encode($totalDislikes) ?></p>

    <h2>Dislikes</h2>
    <?php if (empty($toolDislikes)): ?>
        <p>No dislikes yet for this tool.</p>
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
                <?php foreach ($toolDislikes as $toolDislike): ?>
                    <tr>
                        <!-- 显示点赞的用户 -->
                        <td>
                            <?php
                                // 获取点赞用户信息
                                $user = User::findOne($toolDislike->user_id);
                                if ($user) {
                                    echo Html::encode($user->username);  // 显示用户名
                                } else {
                                    echo 'Unknown User';  // 如果没有找到用户，显示 "Unknown User"
                                }
                            ?>
                        </td>

                        <td><?= Yii::$app->formatter->asDatetime($toolDislike->created_at, 'php:Y-m-d H:i:s') ?></td>
                        <td>
                            <!-- 删除点赞按钮 -->
                            <?= Html::a('Delete', ['delete-disike', 'id' => $toolDislike->id], [
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
