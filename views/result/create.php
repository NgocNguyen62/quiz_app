<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\base\Result $model */

$this->title = 'Create Result';
$this->params['breadcrumbs'][] = ['label' => 'Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="result-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
