<?php
/* @var $this yii\web\View */
/* @var $toolLikes backend\models\ToolLike[] */
/* @var $pagination yii\data\Pagination */
/* @var $tool backend\models\AllAiTool */

use yii\helpers\Html;
use common\models\User;  // 导入 User 模型

$this->title = 'Likes for ' . Html::encode($tool->getAttribute('AI Tool Name'));
$this->params['breadcrumbs'][] = ['label' => 'AI Tools', 'url' => ['ai-tool']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="tool-likes">
    <h2>Tool Information</h2>
    <p><strong>Tool Name:</strong> <?= Html::encode($tool->getAttribute('AI Tool Name')) ?></p>
    <p><strong>Description:</strong> <?= Html::encode($tool->Description) ?></p>

    <!-- 显示点赞总数 -->
    <p><strong>Total Likes:</strong> <?= Html::encode($totalLikes) ?></p>

    <h2>Likes</h2>
    <?php if (empty($toolLikes)): ?>
        <p>No likes yet for this tool.</p>
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
                <?php foreach ($toolLikes as $toolLike): ?>
                    <tr>
                        <!-- 显示点赞的用户 -->
                        <td>
                            <?php
                                // 获取点赞用户信息
                                $user = User::findOne($toolLike->user_id);
                                if ($user) {
                                    echo Html::encode($user->username);  // 显示用户名
                                } else {
                                    echo 'Unknown User';  // 如果没有找到用户，显示 "Unknown User"
                                }
                            ?>
                        </td>

                        <td><?= Yii::$app->formatter->asDatetime($toolLike->created_at, 'php:Y-m-d H:i:s') ?></td>
                        <td>
                            <!-- 删除点赞按钮 -->
                            <?= Html::a('Delete', ['delete-like', 'id' => $toolLike->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this like?',
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