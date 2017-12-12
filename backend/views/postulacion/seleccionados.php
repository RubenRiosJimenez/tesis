<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use backend\models\Convocatoria;
use backend\models\Estadopostulacion;
use backend\models\Evaluacion;
use backend\models\Resultado;
use backend\models\Postulacion;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostulacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listado de postulaciones para asignación de subsidio:';
?>

<!--<br>
<div class='row'>
    <div class="col-lg-12">
        <h4>Montos disponibles para asignación:</h4>
        <br>
    </div>
</div>
<div class='row'>
    <div class="col-lg-7">
        <div class="col-lg-12">
            <h4>Ingrese los datos a filtrar:</h4>

        </div>
<?php
/*

$buscaPostulacion = Postulacion::find()->joinWith('convocatoria')->joinWith('evaluacion')->where(['evaluacion.etapa' => 3])->all();
$flag2 = 0;
foreach($buscaPostulacion as $postulacion){
    $flag = $postulacion->id_convocatoria;
    if($flag2 != $flag){


    $buscaMontos= Postulacion::find()->where(['id_convocatoria' => $postulacion->id_convocatoria])->all();
        $sumaMontos=0;
        foreach ($buscaMontos as $montos) {
            $sumaMontos+= $montos->montoAsignado;
        }
    $monto_total = $postulacion->convocatoria->montoConvocatoria-$sumaMontos; 

        //echo '<strong>'.$postulacion->convocatoria->nombreConvocatoria.': $ '.$monto_total.' pesos. </strong>';
        //echo '<br>';
            echo DetailView::widget([
    'model'=>$model,
    'condensed'=>true,
    'responsive' => true,
    'alertContainerOptions' => ['style'=>'display:none'],
    'bordered' => true,
    'bootstrap' => true,
    'striped' => true,
    'hover'=>true,
    'enableEditMode' => false,
    'hAlign'=>DetailView::ALIGN_LEFT,
    'vAlign' => DetailView::ALIGN_MIDDLE,
    'mode'=>DetailView::MODE_VIEW,
    'panel'=>[
        'type'=>DetailView::TYPE_INFO,
    ],
    'labelColOptions' => [
        'style' => 'max-width: 500px; word-wrap: break-word; font-size: 15px; font-weight: bold;',
    ],
    'valueColOptions' => [
        'style' => 'max-width: 300px; word-wrap: break-word; font-size: 15px; font-weight: bold;',
    ],
    'attributes'=>[

        [
            'label'  => $postulacion->convocatoria->nombreConvocatoria,
            'value'  => '$ '.number_format($monto_total, 0, ",", "."),
        ],

        ],
        ]);
        $flag2 = $postulacion->id_convocatoria;
    }
}

*/?>
</div>
</div>-->

<div class='row'>
    <div class="col-lg-12">
                   <?= Html::a('Exportar a PDF',
['/postulacion/exportarseleccionados'] 
,['title' => Yii::t('yii', 'Exportar a PDF'),'style'=>'float:right', 'class' => 'btn btn-primary', 'aria-label' => Yii::t('yii', 'Exportar a PDF'), 'data-pjax' => '0',] );
?>
    </div>
</div>

<br>
<br>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
            'pjaxSettings'=>[
            'loadingCssClass' => false,
    ],
        'export' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


                [
                'attribute' => 'convocatoria',
                'label' => 'Convocatoria',
                'value'=>'convocatoria.nombreConvocatoria',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },
                'filter'=>Html::activeDropDownList($searchModel,'id_convocatoria',ArrayHelper::map(Convocatoria::find()->where(['id_estadoConvocatoria' => 2])->asArray()->all(), 'id_convocatoria','nombreConvocatoria'),['class'=>'form-control','prompt'=>'Seleccionar']),
            ],

             [
            'attribute' => 'concursante',
            'label' => 'Concursante',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },
            'value'=>'concursante.nombreConcursante'
            ],

             [
            'attribute' => 'rutConcursante',
            'label' => 'Rut',
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },
            'headerOptions' => ['class' => 'text-center'],
            'value'=>'concursante.rut'
            ],
            [
            'attribute' => 'nombreOrganizacion',
            'label' => 'Organización',
            'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },
            'value'=>function($data){
                    if($data->formulario->nombre_organizacion==null){
                        return 'Sin nombre';
                    }else{
                        return $data->formulario->nombre_organizacion;
                    }        
            }
            ],
            [
            'attribute' => 'nombreProyecto',
            'label' => 'Proyecto',
            'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },
            'value'=>function($data){
                    if($data->formulario->nombre_proyecto==null){
                        return 'Sin nombre';
                    }else{
                        return $data->formulario->nombre_proyecto;
                    }        
            }
            ],


            [
            'attribute' => 'fecha_postulacion',
            'label' => 'Fecha de postulación',
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class text-center' => 'tbl_column_name', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },
            'headerOptions' => ['class' => 'text-center'],
                'value'=>function($data){
                    if($data->fecha_postulacion==''){
                        return 'Sin fecha';
                    }else{
                        return date('d-m-Y',strtotime($data->fecha_postulacion));
                    }                  
            }
            ],
            [
                'attribute' => 'total',
                'label'=>'Puntaje final',
                'headerOptions' => ['class' => 'text-center'],                
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },

            'value'=>function ($data) {
                    return $data->evaluacion->puntaje_1 + $data->evaluacion->puntaje_2 + $data->evaluacion->puntaje_3 .' puntos';

            },
            ],   

            [
            'attribute' => 'aporteSolicitado',
            'label' => 'Aporte solicitado',
            'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },
            'value'=>function($data){
                        return '$ '.number_format($data->formulario->financiamiento_aporte_solicitado, 0, ",", ".");    
            }
            ],


            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'montoAsignado',
                'label'=>'Monto asignado ($)',
                'headerOptions' => ['class' => 'text-center'],
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },
            'value' => function($model){
                if($model->montoAsignado == null){
                    return 'Sin asignación de monto.';
                }else{
                    return '$ '.number_format($model->montoAsignado, 0, ",", ".");
                }
            },
            ],            
 
          ['class' => 'yii\grid\ActionColumn',
            'template' => '{download} {buscar} {cambiarEstado}',
            'options'=> ['style'=>'min-width:150px;'],
            'buttons' => ['download'=>function($url,$model,$key){
                if($model->id_estadopostulacion > 1){
                return Html::a('<span class="glyphicon glyphicon-cloud-download"></span>',
['/postulacion/descargarpostulacion','id_postulacion' => $model->id_postulacion] 
,['title' => Yii::t('yii', 'Descargar formulario'), 'aria-label' => Yii::t('yii', 'Descargar formulario'), 'class' => 'btn btn-primary', 'data-pjax' => '0',] );


                }

            },
            'buscar'=>function($url,$model,$key){
                return Html::a('<span class="glyphicon glyphicon-search"></span>',

['viewresultados','id_postulacion' => $model->id_postulacion],['title' => Yii::t('yii', 'Detalle de la postulación'), 'class' => 'btn btn-success', 'aria-label' => Yii::t('yii', 'Detalle de la postulación'), 'data-pjax' => '0',] );
            },

'cambiarEstado'=>function($url,$model,$key){
                return Html::a('<span class="glyphicon glyphicon-share-alt"></span>',

['/postulacion/seleccionapreseleccion','id_postulacion' => $model->id_postulacion] ,['title' => Yii::t('yii', 'Regresar postulación a la etapa de pre-selección'),'aria-label' => Yii::t('yii', 'Regresar postulación a la etapa anterior'), 'class'=>'btn btn-warning', 'data-confirm' => Yii::t('yii', '¿Estás seguro que deseas regresar esta postulación a la etapa de pre-selección?'),'data-method' => 'post','data-pjax' => '0',] );
        },               


            ],
            ],
        ],
    ]); ?>