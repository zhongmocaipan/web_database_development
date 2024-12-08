<?php

/* @var $this yii\web\View */
/* @var $papers common\models\ArxivPaper[] */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Paper Management';
?>

<div class="paper-management">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- 显示所有的论文 -->
    <h3>All Papers</h3>

    <?= GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'allModels' => $papers,
            'pagination' => ['pageSize' => 10],
        ]),
        'columns' => [
            'title',
            'authors',
            'published',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::a('Delete', ['delete-paper', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this paper?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

    <!-- 添加论文的按钮 -->
    <p>
        <?= Html::a('Add Paper', ['add-paper'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
