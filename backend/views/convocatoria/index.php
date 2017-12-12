<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Postulacion;
use backend\models\Convocatoria;
use backend\models\fondo;
use backend\models\Resultado;
use backend\models\Estadoconvocatoria;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ConvocatoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model backend\models\Fondo */

$this->title = 'Convocatorias:';
?>
<?php
 $request = Yii::$app->request;
 ?>

<div class="convocatoria-index">

<div style="overflow: auto;">

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'nombreConvocatoria',
                'label'=>'Convocatoria',
                'headerOptions' => ['class' => 'text-center'],
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },
            'value'=>function($data){
                    return $data->nombreConvocatoria;
            }
            ],
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
                'attribute' => 'montoConvocatoria',
                'label'=>'Monto',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            }, 
            'value'=>function($data){

                    return '$ '.number_format($data->montoConvocatoria, 0, ",", ".").' pesos';
            }
            ], 

                 [
                //'attribute' => 'Total de postulaciones',
                'label'=>'N° de postulaciones',
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
                                        case 4:
                                        return Html::tag('span','&nbsp;&nbsp;&nbsp;&nbsp;'. $data->estadoconvocatoria->nombre_estado.'&nbsp;&nbsp;&nbsp;&nbsp;', ['class' => 'label label-warning', 'style'=>' font-size: 12px;']);
                                        break;                                        
                                    }
                                },


             'headerOptions' => ['class' => 'text-center'],
          
            
            ],

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{update} {cambiarEstado} {delete}',
            'options'=> ['style'=>'min-width:120px;'],            
            'buttons' => ['update'=>function($url,$model,$key){

                if($model->id_estadoConvocatoria!=3){
                $cantidad_postulaciones= Postulacion::find()->where(['id_convocatoria'=>$model->id_convocatoria])->count();
               if($cantidad_postulaciones>=1){


                return Html::a('<span class="glyphicon glyphicon-pencil"></span>',

             ['/convocatoria/update2','id_convocatoria' => $model->id_convocatoria],['title' => Yii::t('yii', 'Modificar convocatoria'), 'class' => 'btn btn-primary', 'aria-label' => Yii::t('yii', 'Modificar convocatoria'), 'data-pjax' => '0',] );
               }else{



                return Html::a('<span class="glyphicon glyphicon-pencil"></span>',

            ['/convocatoria/update','id_convocatoria' => $model->id_convocatoria],['title' => Yii::t('yii', 'Modificar convocatoria'), 'class' => 'btn btn-primary', 'aria-label' => Yii::t('yii', 'Modificar convocatoria'), 'data-pjax' => '0',] );
               }

          }
            },

'cambiarEstado'=>function($url,$model,$key){

date_default_timezone_set('America/Santiago');
$fecha_actual= getdate();

$fecha_hoy= date('Y-m-d', strtotime($fecha_actual['year'].'-'.$fecha_actual['mon'].'-'.$fecha_actual['mday']));

if($fecha_hoy <= $model->fecha_termino && $fecha_hoy >= $model->fecha_inicio && $model->id_estadoConvocatoria!=3 && $model->id_estadoConvocatoria!=2){

                return Html::a('<span class="glyphicon glyphicon-share-alt"></span>',

['/convocatoria/cambiarestado','id_convocatoria' => $model->id_convocatoria] ,['title' => Yii::t('yii', 'Cambiar estado de la convocatoria'),'aria-label' => Yii::t('yii', 'Cambiar estado de la convocatoria'), 'class'=>'btn btn-warning', 'data-confirm' => Yii::t('yii', '¿Estás seguro que deseas cambiar el estado de la convocatoria?'),'data-method' => 'post','data-pjax' => '0',] );

            }
        },    

'delete'=>function($url,$model,$key){

    if($model->id_estadoConvocatoria!=3){
    $buscaPostulacion = Postulacion::find()->where(['id_convocatoria' => $model->id_convocatoria])->one();
if($buscaPostulacion == null){
                return Html::a('<span class="glyphicon glyphicon-trash"></span>',
['/convocatoria/delete','id_convocatoria' => $model->id_convocatoria],['title' => Yii::t('yii', 'Eliminar convocatoria'),'aria-label' => Yii::t('yii', 'Eliminar convocatoria'),'data-confirm' => Yii::t('yii', '¿Estas seguro que deseas eliminar esta convocatoria?'), 'class' => 'btn btn-danger', 'data-method' => 'post','data-pjax' => '0',] );
            }

        }
        },



            ],
            ],
        ],
    ]); ?>

    <p>

        <?= Html::a('Agregar convocatoria',['/convocatoria/create'],['class'=> 'btn btn-success', 'title' => Yii::t('yii', 'Agregar convocatoria'), 'aria-label' => Yii::t('yii', 'Agregar convocatoria'), 'data-pjax' => '0',] );?>
    </p>    

<?php Pjax::end(); ?></div>
</div>

