<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\base\Template $template */
/** @var app\models\base\Question[]  $questions*/

$this->title = 'Take Quiz for Template: ' . $template->id;
$this->params['breadcrumbs'][] = ['label' => 'Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<head>
    <title>Take Quiz</title>
    <style>
        .question-block{
            margin: 10px;
        }
        .radio{
            margin-bottom: 10px;
        }
    </style>
</head>

<div class="quiz-form">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?php foreach ($questions as $question): ?>
        <div class="question-block">
            <p><strong><?= Html::encode($question->question_text) ?></strong></p>
            <?php foreach ($question->answers as $answer): ?>
                <div class="radio">
                    <label>
                        <?= Html::radio("QuizForm[answers][$question->id]", false, ['value' => $answer->id]) ?>
                        <?= Html::encode($answer->answer_text) ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton('Submit Quiz', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
