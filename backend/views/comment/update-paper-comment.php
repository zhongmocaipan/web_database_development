<?php
/* @var $this yii\web\View */
/* @var $paper backend\models\ArxivPaper */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Update Comment: ' . Html::encode($comment->id);
$this->params['breadcrumbs'][] = ['label' => 'Paper Comment', 'url' => ['view-paper-comments']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin([
    'id' => 'update-paper-form',
    'action' => ['comment/update-paper-comment', 'id' => $comment->paper_id],  // 确保正确的 action
    'enableAjaxValidation' => false, // 不启用AJAX验证
    'options' => ['class' => 'form-horizontal'],
]); ?>


    <?= $form->field($comment, 'content')->textarea(['rows' => 6, 'placeholder' => 'Update paper description here']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>