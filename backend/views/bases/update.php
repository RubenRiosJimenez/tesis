<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\bases */

$this->title = Yii::t('app', 'Actualizar {modelClass}: ', [
    'modelClass' => 'Bases',
]) . $model->nombre_base;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_base, 'url' => ['view', 'id' => $model->id_base]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizar');
?>
<div class="bases-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
