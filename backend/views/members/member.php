<?php
use yii\helpers\Html;
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端查看团队组员信息页面
*/
$this->title = 'Member Management';
?>

<h1><?= Html::encode($this->title) ?></h1>

<!-- 添加新成员按钮 -->
<div class="form-group">
    <?= Html::a('Add New Member', ['members/add'], ['class' => 'btn btn-success']) ?>
</div>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Member ID</th>
            <th>Member Name</th>
            <th>Member School ID</th>
            <th>Zhi Wei</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($members as $member): ?>
            <tr>
                <td><?= Html::encode($member->memberID) ?></td>
                <td><?= Html::encode($member->membername) ?></td>
                <td><?= Html::encode($member->memberschoolID) ?></td>
                <td><?= Html::encode($member->zuzhangorduiyuan) ?></td>
                <td><?= Html::encode($member->created_at) ?></td>
                <td>
                    <?= Html::a('Update', ['members/update', 'id' => $member->memberID], ['class' => 'btn btn-primary btn-sm']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
