// backend/views/user/update.php
<?php
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端用户信息更新页面
*/
?>
<h1>Update User: <?= $user->username ?></h1>

<?php $form = \yii\widgets\ActiveForm::begin(); ?>

<?= $form->field($user, 'username') ?>
<?= $form->field($user, 'email') ?>
<?= $form->field($user, 'status')->dropDownList([1 => 'Active', 0 => 'Inactive']) ?>

<button class="btn btn-success">Save</button>

<?php \yii\widgets\ActiveForm::end(); ?>
