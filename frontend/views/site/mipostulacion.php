<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use frontend\models\Resultado;
use frontend\models\Evaluacion;
use frontend\models\Concursante;
use frontend\models\Postulacion;
use frontend\models\Estadopostulacion;
use frontend\models\Convocatoria;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PostulacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Mis postulaciones');


?>
<div class="postulacion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
<div class='row'>
    <div class="col-lg-5">
        Listado de mis postulaciones:
    </div>
</div>
        <div style="overflow: auto;">

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id_postulacion',

            //'id_convocatoria',
            //'convocatoria.nombreConvocatoria',

            [
                'label'=>'Convocatoria',
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },

            'value'=>function($data){
                    return $data->convocatoria->nombreConvocatoria;

            }
            ], 
                         [
                'label' => 'Estado de la postulación',
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'html',
                                'value'=>function($data){
                                    switch($data->id_estadopostulacion){
                                        case 1:
                                        return Html::tag('span', '&nbsp;'.$data->estadopostulacion->nombre_estadopostulacion.'&nbsp;', ['class' => 'label label-danger', 'style'=>'font-size: 12px;']);
                                        break;
                                        case 2:
                                        return Html::tag('span', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$data->estadopostulacion->nombre_estadopostulacion.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', ['class' => 'label label-success', 'style'=>' font-size: 12px;']);
                                        break;
                                        case 3:
                                        return Html::tag('span', '&nbsp;&nbsp;&nbsp;&nbsp;'.$data->estadopostulacion->nombre_estadopostulacion.'&nbsp;&nbsp;&nbsp;&nbsp;', ['class' => 'label label-primary', 'style'=>' font-size: 12px;']);
                                        break;
                                        case 4:
                                        return Html::tag('span','&nbsp;'.$data->estadopostulacion->nombre_estadopostulacion, ['class' => 'label label-warning', 'style'=>' font-size: 12px;']);
                                        break;                                                                       
                                    }
                                },
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
                'filter'=>Html::activeDropDownList($searchModel,'id_estadopostulacion',ArrayHelper::map(Estadopostulacion::find()->asArray()->all(), 'id_estadopostulacion','nombre_estadopostulacion'),['class'=>'form-control','prompt'=>'Filtrar']),
            ],


            [//'format' => 'date',
                //'attribute' => 'fecha_postulacion',
                'label'=>'Fecha de postulación',
                 'value'=>function($data){
                    //setlocale(LC_ALL, 'es_ES');
                    $fecha=  date('d-m-Y',strtotime($data->fecha_postulacion));
                    if($fecha!='01-01-1970'){
                        return date('d-m-Y',strtotime($data->fecha_postulacion));
                    
                    }else{
                        'No fue enviado el formulario';
                    }
                    //return $data->fecha_subida; 
            },
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

           
            ],  




            ['class' => 'yii\grid\ActionColumn',
            'template' => '{download} {ver}',
            'buttons' => ['download'=>function($url,$model,$key){

                return Html::a('<span class="glyphicon glyphicon-cloud-download"></span>',

['/site/descargarpostulacion','id_convocatoria' => $model->id_convocatoria] ,['title' => Yii::t('yii', 'Descargar formulario de postulación'), 'aria-label' => Yii::t('yii', 'Descargar formulario de postulación'), 'class'=>'btn btn-primary', 'data-pjax' => '0',] );
                },

        'ver'=>function($url,$model,$key){

        $buscaEvaluacion = Evaluacion::find()->where(['id_postulacion' => $model->id_postulacion])->one();
        $buscaConvocatoria = Convocatoria::find()->where(['id_convocatoria' => $model->id_convocatoria])->one();
        if($buscaEvaluacion != null && $buscaConvocatoria->id_estadoConvocatoria==3){

                            return Html::a('<span class="glyphicon glyphicon-search"></span>',

            ['/site/mostrardetallepostulacion','id_convocatoria' => $model->id_convocatoria,'id_postulacion'=>$model->id_postulacion],['title' => Yii::t('yii', 'Detalle de la evaluación'), 'class' => 'btn btn-success', 'aria-label' => Yii::t('yii', 'Detalle de la evaluación'), 'data-pjax' => '0',] );
                        
            }

            },



            ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div></div>
