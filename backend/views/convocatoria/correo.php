<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Postulacion;
use backend\models\Convocatoria;
use backend\models\Estadoconvocatoria;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ConvocatoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Módulo de envío de correos electrónicos:';
?>
<?php
 $request = Yii::$app->request;
 ?>

<div class="convocatoria-index">
    <div class="col-lg-12">
        <?= Html::a('<span class="glyphicon glyphicon-envelope"></span> Enviar correo a todos los concursantes',
['/convocatoria/enviarcorreosconcursantes'] 
,['title' => Yii::t('yii', 'Redactar correo a todos los concursantes'),'style'=>'float:right', 'class' => 'btn btn-primary', 'aria-label' => Yii::t('yii', 'Redactar correo a todos los concursantes'), 'data-pjax' => '0',] );
?>
        <br>
  <br>
    <p>
        A continuación se listarán las convocatorias:
    </p>

<br>

<div style="overflow: auto;">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'nombreConvocatoria',
                'label'=>'Nombre de la convocatoria',
                'headerOptions' => ['class' => 'text-center'],
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },
            'value'=>function($data){
                    return $data->nombreConvocatoria;
            }
            ],           

            [
                'attribute' => 'fecha_inicio',
                'label'=>'Fecha de inicio',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function($data){
                    return date('d-m-Y',strtotime($data->fecha_inicio));
            }
            ],

            [
                'attribute' => 'fecha_termino',
                'label'=>'Fecha de término',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function($data){
                    return date('d-m-Y',strtotime($data->fecha_termino));
            }
            ], 

                 [
                //'attribute' => 'Total de postulaciones',
                'label'=>'Total de postulaciones    ',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function($data){
                  $cantidad_postulaciones= Postulacion::find()->where(['id_convocatoria'=>$data->id_convocatoria])->count();
                return $cantidad_postulaciones;
            }
            ], 

            [
            'attribute' => 'estadoconvocatoria',

             'label'=>'Estado de la convocatoria',
             'contentOptions' => ['class' => 'text-center'],
            'format' => 'html',
                                'value'=>function($data){
                                    switch($data->id_estadoConvocatoria){
                                        case 1:
                                        return Html::tag('span', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$data->estadoconvocatoria->nombre_estado.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', ['class' => 'label label-success', 'style'=>'font-size: 12px;']);
                                        break;
                                        case 2:
                                        return Html::tag('span', '&nbsp;&nbsp;&nbsp;&nbsp;'.$data->estadoconvocatoria->nombre_estado.'&nbsp;&nbsp;&nbsp;&nbsp;', ['class' => 'label label-danger', 'style'=>' font-size: 12px;']);
                                        break;
                                        case 3:
                                        return Html::tag('span','&nbsp;&nbsp;'. $data->estadoconvocatoria->nombre_estado.'&nbsp;&nbsp;', ['class' => 'label label-primary', 'style'=>' font-size: 12px;']);
                                        break;
                                    }
                                },


             'headerOptions' => ['class' => 'text-center'],
          
            
            ],           

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{update} {create}',
            'buttons' => ['update'=>function($url,$model,$key){

           
        $cantidad_postulaciones= Postulacion::find()->where(['id_convocatoria'=>$model->id_convocatoria])->count();
        if($cantidad_postulaciones > 0){


             return Html::a('<span class="glyphicon glyphicon-envelope"></span>',

            ['/convocatoria/enviarcorreo','id_convocatoria' => $model->id_convocatoria],['title' => Yii::t('yii', 'Redactar correo para los concursantes'), 'class' => 'btn btn-primary', 'aria-label' => Yii::t('yii', 'Redactar correo para los concursantes'), 'data-pjax' => '0',] );
               }

          
            },
'create'=>function($url,$model,$key){

                        if($model->id_estadoConvocatoria==3){
                          return Html::a('<span class="glyphicon glyphicon-send"></span>',
    ['/convocatoria/enviarresultados','id_convocatoria' => $model->id_convocatoria],['title' => Yii::t('yii', 'Enviar resultados de la convocatoria'), 'class' => 'btn btn-success', 'aria-label' => Yii::t('yii', 'Enviar resultados de la convocatoria'), 'data-pjax' => '0',] );
             

                        }

               
        },



            ],
            ],
        ],
    ]); ?>

      

<?php Pjax::end(); ?></div>
</div>
