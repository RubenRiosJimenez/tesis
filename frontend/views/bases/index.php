<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
/**
 * Created by PhpStorm.
 * User: Rubén
 * Date: 02-12-2017
 * Time: 19:44
 */

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model backend\models\Fondo */


$this->title = Yii::t('app', 'Bases Fondos Municipales');
?>

<div class="bases-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <div class='row'>
        <div class="col-lg-5">
            Listado de Bases:
        </div>
    </div>

    <div style="overflow: auto;">

<?= GridView::widget([
    'dataProvider' => $dataProvider,

    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'itemView' => 'nombre_base' ,'fecha_creacion_base',

        ['class' => 'yii\grid\ActionColumn',
            'template' => '{Ver}',
            'options'=> ['style'=>'min-width:150px;'],
            'buttons' => [
                'Ver'=>function($url,$model,$key){


                    return
                        Html::a(Yii::t('app', '<span class="glyphicon glyphicon-eye-open"></span>'), Url::toRoute(['bases/detalle', 'id' => $model->id_base]), ['class' => 'btn btn-primary']);


                },

            ],
        ],
],

    ]); ?>
