<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\bases */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Bases',
]) . $model->id_base;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_base, 'url' => ['view', 'id' => $model->id_base]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="bases-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
