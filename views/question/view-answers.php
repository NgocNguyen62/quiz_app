<?php

use app\models\base\Answer;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\search\AnswerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\base\Question $question */

$this->title = 'Answers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Answer', ['question/create-answer',  'question_id' => $question->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'question_id',
            'answer_text:ntext',
            'is_correct',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Answer $model, $key, $index, $column) {
                    return Url::toRoute(['answer/'.$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
