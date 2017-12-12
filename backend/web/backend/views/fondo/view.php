<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Fondo */

$this->title = $model->id_fondo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fondos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fondo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_fondo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_fondo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_fondo',
            'nombre_fondo',
            'estado_fondo',
            'observacion_fondo:ntext',
            'fecha_creacion',
        ],
    ]) ?>

</div>
