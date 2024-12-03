<?php
use yii\helpers\Html;

?>

<h1>User Management</h1>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= Html::encode($user->id) ?></td>
                <td><?= Html::encode($user->username) ?></td>
                <td><?= Html::encode($user->email) ?></td>
                <td><?= $user->status == 0 ? 'Active' : 'Inactive' ?></td>
                <td>
                    <a href="<?= \yii\helpers\Url::to(['user/view', 'id' => $user->id]) ?>" class="btn btn-primary">View</a>
                    <a href="<?= \yii\helpers\Url::to(['user/update', 'id' => $user->id]) ?>" class="btn btn-warning">Update</a>
                    <a href="<?= \yii\helpers\Url::to(['user/delete', 'id' => $user->id]) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
