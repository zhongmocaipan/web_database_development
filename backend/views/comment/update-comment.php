<?php
/*
 * Team：LOVEYII
 * Coding By：胡雨欣 2212117
 * 后端更新评论tool页面
*/
/* @var $this yii\web\View */
/* @var $comment backend\models\ToolComment */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Update Comment: ' . Html::encode($comment->id);
$this->params['breadcrumbs'][] = ['label' => 'Tool Comments', 'url' => ['view-comments']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin([
    'id' => 'update-comment-form',
    'action' => ['comment/update-comment', 'id' => $comment->id],
    'enableAjaxValidation' => false, // 不启用AJAX验证
    'options' => ['class' => 'form-horizontal'],
]); ?>

    <?= $form->field($comment, 'content')->textarea(['rows' => 6, 'placeholder' => 'Update your comment here']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>



