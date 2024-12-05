<?php
/* @var $this yii\web\View */
/* @var $tools array 数据库中所有工具的数组 */

use yii\helpers\Html;
use yii\helpers\Url;
?>

<h1>AI 工具列表</h1>

<?php if (empty($tools)): ?>
    <p>没有找到任何工具。</p>
<?php else: ?>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>工具名称</th>
                <th>描述</th>
                <th>免费/付费</th>
                <th>适用领域</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tools as $tool): ?>
                <tr>
                    <td><?= Html::encode($tool['AI Tool Name']) ?></td>
                    <td><?= Html::encode($tool['Description']) ?></td>
                    <td><?= Html::encode($tool['Free/Paid/Other']) ?></td>
                    <td><?= Html::encode($tool['Useable For']) ?></td>
                    <td>
                        <!-- 添加评论按钮，点击后跳转到评论页面 -->
                        <a class="btn btn-default" href="<?= Url::to(['site/toolcomment', 'tool_name' => $tool['AI Tool Name']]) ?>">Comments & Like</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
