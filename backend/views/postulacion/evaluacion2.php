<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use backend\models\Convocatoria;
use backend\models\Estadoresultado;
use backend\models\Estadoevaluacion;
use backend\models\Resultado;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostulacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Postulaciones pre-seleccionadas para la asignación de subsidio:';
?>


<div class='row'>
    <div class="col-lg-12">
                   <?= Html::a('Exportar a PDF',
['/postulacion/exportarevaluaciones2'] 
,['title' => Yii::t('yii', 'Exportar a PDF'),'style'=>'float:right', 'class' => 'btn btn-primary', 'aria-label' => Yii::t('yii', 'Exportar a PDF'), 'data-pjax' => '0',] );
?>
 
        <br>
  <br>
    </div>
</div>
<br>
<br>
 <div style="overflow: auto;">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                'filter'=>Html::activeDropDownList($searchModel,'id_convocatoria',ArrayHelper::map(Convocatoria::find()->where(['id_estadoConvocatoria' => 2])->asArray()->all(), 'id_convocatoria','nombreConvocatoria'),['class'=>'form-control','prompt'=>'Filtrar']),
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
            'contentOptions' => ['class' => 'text-center'],
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
            'contentOptions' => ['class' => 'text-center'],
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
                'label' => 'Estado de la asignación',
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'html',
                                'value'=>function($data){
                                    $buscaResultado = Resultado::find()->where(['id_evaluacion' => $data->evaluacion->id_evaluacion])->one();
                                    if($buscaResultado != null){
                                    $buscaEstadoResultado = Estadoresultado::find()->where(['id_estado' => $buscaResultado->id_estado])->one();
                                    }                                    
                                    if($buscaResultado == null || $buscaResultado->id_estado == 1){
                                        return Html::tag('span','Pendiente de revisión', ['class' => 'label label-warning', 'style'=>'font-size: 12px;']);
                                    }else{
                                        return Html::tag('span','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$buscaEstadoResultado->descripcion_estado.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', ['class' => 'label label-danger', 'style'=>'font-size: 12px;']);
                                    }                                                                
                                },
                'headerOptions' => ['class' => 'text-center'],
            ],              

            [
                'attribute' => 'total',
                'label'=>'Puntaje final',
                'headerOptions' => ['class' => 'text-center'],                
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function ($data) {
                    return $data->evaluacion->puntaje_1 + $data->evaluacion->puntaje_2 + $data->evaluacion->puntaje_3 .' puntos';

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
                return Html::a('<span class="glyphicon glyphicon-thumbs-up"></span>',

['view','id_postulacion' => $model->id_postulacion],['title' => Yii::t('yii', 'Asignar subsidio'), 'class' => 'btn btn-success', 'aria-label' => Yii::t('yii', 'Asignar subsidio'), 'data-pjax' => '0',] );
            },

'cambiarEstado'=>function($url,$model,$key){
                return Html::a('<span class="glyphicon glyphicon-share-alt"></span>',

['/postulacion/preseleccionaevaluacion','id_postulacion' => $model->id_postulacion] ,['title' => Yii::t('yii', 'Regresar postulación a la etapa de evaluación'),'aria-label' => Yii::t('yii', 'Regresar postulación a la etapa anterior'), 'class'=>'btn btn-warning', 'data-confirm' => Yii::t('yii', '¿Estás seguro que deseas regresar esta postulación a la etapa de evaluación?'),'data-method' => 'post','data-pjax' => '0',] );
        },            


            ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
    </div>
</div>

