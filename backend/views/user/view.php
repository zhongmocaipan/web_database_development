// backend/views/user/view.php
<?php
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端查看用户页面
*/
?>
<h1>View User: <?= $user->username ?></h1>

<p>Email: <?= $user->email ?></p>
<p>Status: <?= $user->status == 0 ? 'Active' : 'Inactive' ?></p>

<a href="<?= \yii\helpers\Url::to(['user/update', 'id' => $user->id]) ?>" class="btn btn-warning">Update</a>
<a href="<?= \yii\helpers\Url::to(['user/delete', 'id' => $user->id]) ?>" class="btn btn-danger">Delete</a>
