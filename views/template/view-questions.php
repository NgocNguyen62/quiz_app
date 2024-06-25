<?php
/** @var yii\web\View $this */
/** @var app\models\search\QuestionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\base\Template $template */

use app\models\base\Question;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Questions for Template: ' . $template->id;
$this->params['breadcrumbs'][] = ['label' => 'Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="question-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Question', ['create-question', 'template_id' => $template->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'template_id',
            'question_text:ntext',
            [
                'attribute' => 'answers',
                'label' => 'Answers',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->getCorrectAnswer();
                }
            ],
            [
                'attribute' => 'option1',
                'label' => 'Option 1',
                'value' => function ($model) {
                    return $model->getOptions()[0]->answer_text ?? '';
                }
            ],
            [
                'attribute' => 'option2',
                'label' => 'Option 2',
                'value' => function ($model) {
                    return $model->getOptions()[1]->answer_text ?? '';
                }
            ],
            [
                'attribute' => 'option3',
                'label' => 'Option 3',
                'value' => function ($model) {
                    return $model->getOptions()[2]->answer_text ?? '';
                }
            ],

            [
                'attribute' => 'option4',
                'label' => 'Option 4',
                'value' => function ($model) {
                    return $model->getOptions()[3]->answer_text ?? '';
                }
            ],

            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete} {view-answers}',
                'buttons' => [
                    'view-answers' => function ($url, $model, $key) {
                        return Html::a('View Answers', ['question/view-answers', 'id' => $model->id], ['class' => 'btn btn-info']);
                    },
                ],
                'urlCreator' => function ($action, Question $model, $key, $index, $column) {
                    return Url::toRoute(['question/'. $action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

