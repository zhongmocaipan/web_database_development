<?php
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端paper页面
*/
/* @var $this yii\web\View */
/* @var $paper common\models\ArxivPaper */

use yii\helpers\Html; // 导入 Html 类

$this->title = 'Add Paper';
?>

<div class="add-paper">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="paper-form">

        <?php $form = \yii\widgets\ActiveForm::begin(); ?>

        <?= $form->field($paper, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($paper, 'abstract')->textarea(['rows' => 6]) ?>

        <?= $form->field($paper, 'authors')->textInput(['maxlength' => true]) ?>

        <?= $form->field($paper, 'published')->input('date') ?>

        <div class="form-group">
            <?= Html::submitButton('Save Paper', ['class' => 'btn btn-success']) ?>
        </div>

        <?php \yii\widgets\ActiveForm::end(); ?>

    </div>

</div>
