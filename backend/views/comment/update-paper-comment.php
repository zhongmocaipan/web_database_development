<?php
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端更新paper评论页面
*/
/* @var $this yii\web\View */
/* @var $comment backend\models\Comment */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Update Comment: ' . Html::encode($comment->id);
$this->params['breadcrumbs'][] = ['label' => 'Paper Comment', 'url' => ['view-paper-comments']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin([
    'id' => 'update-paper-form',
    'action' => ['comment/update-paper-comment', 'id' => $comment->id],  // 使用评论的主键 ID
    'enableAjaxValidation' => false,
    'options' => ['class' => 'form-horizontal'],
]); ?>

    <?= $form->field($comment, 'content')->textarea(['rows' => 6, 'placeholder' => 'Update paper description here']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>
