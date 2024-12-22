<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端增加组员信息页面
*/
/* @var $this yii\web\View */
/* @var $model backend\models\Members */

$this->title = 'Add New Member';
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="members-add">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'] // 支持文件上传
    ]); ?>

    <!-- Member Name -->
    <?= $form->field($model, 'membername')->textInput(['maxlength' => true]) ?>

    <!-- Member School ID -->
    <?= $form->field($model, 'memberschoolID')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'zuzhangorduiyuan')->dropDownList([
        '团队' => '团队',
        '队长' => '队长',
        '队员' => '队员'
    ], ['prompt' => 'Select Role']) ?>

    <!-- Member Homework (File Upload) -->
    <?= $form->field($model, 'memberhomework')->fileInput() ?>

    <!-- Zuzhang or Duiyuan (DropDown List) -->

    <div class="form-group">
        <?= Html::submitButton('Add Member', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
