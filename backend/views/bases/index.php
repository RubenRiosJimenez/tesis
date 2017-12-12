<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\fondo;
use backend\models\bases;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model backend\models\Fondo */

$this->title = Yii::t('app', 'Lista de Bases');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bases-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Crear Base'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id_base',
            'nombre_base:ntext',
            'fecha_creacion_base',
            [

                'label'=>'Nombre Fondo',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
                },
                //'attribute'=>'nombre_fondo',
                'value'=>function($model){
                    $fondo=$model->fondo;
                    if($fondo!=null){
                        return $model->fondo->nombre_fondo;
                    }else{
                        return "No tiene fondo";
                    }
                }
            ],


            ['class' => 'yii\grid\ActionColumn',
                'template' => '{Eliminar} {Modificar} {Ver}',
                'options'=> ['style'=>'min-width:150px;'],
                'buttons' => [
                    'Eliminar'=>function($url,$model,$key){


                        return  Html::a(Yii::t('app', '<span class="glyphicon glyphicon-trash"></span>'), ['delete', 'id' => $model->id_base], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', '¿Está seguro de eliminar esta base?'),
                                'method' => 'post',
                            ],
                        ]);



                    },

                    'Modificar'=>function($url,$model,$key){


                        return
                            Html::a(Yii::t('app', '<span class="glyphicon glyphicon-edit"></span>'), ['update', 'id' => $model->id_base], ['class' => 'btn btn-primary']);


                    },
                    'Ver'=>function($url,$model,$key){


                        return
                            Html::a(Yii::t('app', '<span class="glyphicon glyphicon-eye-open"></span>'), ['view', 'id' => $model->id_base], ['class' => 'btn btn-primary']);


                    },


                ],

            ],

        ],
    ]); ?>
</div>
