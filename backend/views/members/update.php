<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端更新他团队用户信息页面
*/
/* @var $this yii\web\View */
/* @var $model backend\models\Members */

$this->title = 'Update Member: ' . Html::encode($model->membername);
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="members-update">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'] // 支持文件上传
    ]); ?>

    <!-- Member Name -->
    <?= $form->field($model, 'membername')->textInput(['maxlength' => true]) ?>

    <!-- Member School ID -->
    <?= $form->field($model, 'memberschoolID')->textInput(['type' => 'number']) ?>
    <!-- Zuzhang or Duiyuan (DropDown List) -->
    <?= $form->field($model, 'zuzhangorduiyuan')->dropDownList([
        '团队' => '团队',
        '队长' => '队长',
        '队员' => '队员'
    ], ['prompt' => 'Select Role']) ?>

    <!-- Member Homework (File Upload) -->
    <?= $form->field($model, 'memberhomework')->fileInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Update Member', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
