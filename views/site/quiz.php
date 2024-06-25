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

    <h1><?= Html::encode($this->title) ?></h1>


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'content:ntext',

            [
                'header' => 'Action',
                'class' => 'yii\grid\Column',
                'content' => function ($model, $key, $index, $column) {
                    $takeQuizButton = Html::a('Take Quiz', ['template/take-quiz', 'template_id' => $model->id], ['class' => 'btn btn-success']);
                    $copyButton = Html::a('Copy', ['template/increment-copy-count', 'id' => $model->id], [
                        'class' => 'btn btn-primary',
                        'data-content' => $model->content,
                        'data-id' => $model->id,
                        'onclick' => 'copyToClipboard(this); return false;',
                    ]);
                    if($model->canCopy()) {
                        return $takeQuizButton . ' ' . $copyButton;
                    }
                    return $takeQuizButton;
                }
            ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>
    <?php
    $this->registerJsFile('@web/js/copy.js', ['depends' => [\yii\web\JqueryAsset::class]]);
    ?>


</div>
