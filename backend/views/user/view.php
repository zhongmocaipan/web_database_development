// backend/views/user/view.php

<h1>View User: <?= $user->username ?></h1>

<p>Email: <?= $user->email ?></p>
<p>Status: <?= $user->status ?></p>

<a href="<?= \yii\helpers\Url::to(['user/update', 'id' => $user->id]) ?>" class="btn btn-warning">Update</a>
<a href="<?= \yii\helpers\Url::to(['user/delete', 'id' => $user->id]) ?>" class="btn btn-danger">Delete</a>
