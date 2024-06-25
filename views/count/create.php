<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\base\Count $model */

$this->title = 'Create Count';
$this->params['breadcrumbs'][] = ['label' => 'Counts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="count-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
