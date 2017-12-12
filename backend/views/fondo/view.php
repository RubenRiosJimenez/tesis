<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Fondo */

$this->title = 'Datos del fondo';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fondos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fondo-view">


    <p>
        <?= Html::a(Yii::t('app', 'Editar'), ['update', 'id' => $model->id_fondo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Volver'), ['index', 'id' => $model->id_fondo], ['class' => 'btn btn-primary']) ?>
       <!-- <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $model->id_fondo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '¿Está seguro de eliminar este fondo?'),
                'method' => 'post',
            ],
        ]) ?>-->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_fondo',
            'nombre_fondo',
            'nombre_estado',
            'observacion_fondo:ntext',
            'fecha_creacion',
        ],
    ]) ?>

</div>
