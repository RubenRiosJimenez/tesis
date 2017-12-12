<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Fondo */

$this->title = Yii::t('app', 'Editar {modelClass}: ', [
    'modelClass' => 'Fondo',
]) . $model->id_fondo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fondos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_fondo, 'url' => ['view', 'id' => $model->id_fondo]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Modificar');
?>
<div class="fondo-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
