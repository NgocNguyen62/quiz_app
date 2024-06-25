<?php

use app\models\base\Template;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\search\TemplateSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Templates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-index">

    <?= Html::a('Export Excel', ['export'], ['class' => 'btn btn-primary']) ?>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Template', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'content:ntext',
            [
                 'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete} {view-questions}',
                'buttons' => [
                    'view-questions' => function ($url, $model, $key) {
                        return Html::a('View Questions', ['view-questions', 'id' => $model->id], ['class' => 'btn btn-info']);
                    },
                ],
                'urlCreator' => function ($action, Template $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
//            [
//                'header' => 'Take Quiz',
//                'class' => 'yii\grid\Column',
//                'content' => function ($model, $key, $index, $column) {
//                    return Html::a('Take Quiz', ['template/take-quiz', 'id' => $model->id], ['class' => 'btn btn-success']);
//                }
//            ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
