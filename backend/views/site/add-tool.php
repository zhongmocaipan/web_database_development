<?php

/* @var $this yii\web\View */
/* @var $model backend\models\AllAiTool */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Add AI Tool';
$this->params['breadcrumbs'][] = ['label' => 'AI Tool Management', 'url' => ['tool-management']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="add-tool">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to add a new AI tool:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'add-tool-form',
        'options' => ['class' => 'form-horizontal'],
    ]); ?>

<?= $form->field($model, 'aiToolName')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'Description')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'freePaidOther')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'useableFor')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'Charges')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'Review')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'toolLink')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'majorCategory')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Add Tool', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
