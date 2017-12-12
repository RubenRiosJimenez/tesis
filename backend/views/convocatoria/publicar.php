<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Postulacion;
use backend\models\Resultado;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ConvocatoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Publicar resultados:';
?>
<?php
 $request = Yii::$app->request;
 ?>

<div class="convocatoria-index">

<br>
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

                'label'=>'Postulaciones enviadas',
                'headerOptions' => ['class' => 'text-center'],
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function ($data) {

               $buscaPostulacion = Postulacion::find()->where(['and',['id_convocatoria' => $data->id_convocatoria],['id_estadopostulacion' => 2]])->count();
               return $buscaPostulacion;
            },
            ],

            [

                'label'=>'Postulaciones evaluadas',
                'headerOptions' => ['class' => 'text-center'],
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function ($data) {
                $cont = 0;
               $buscaPostulacion = Postulacion::find()->joinWith('evaluacion')->andWhere(['id_convocatoria' => $data->id_convocatoria])->andWhere(['>','evaluacion.id_estado', 1])->all();
               foreach ($buscaPostulacion as $postulacion){
                if($postulacion->evaluacion->id_estado == 2){
                    $cont ++;                
               }else{
                    if($postulacion->evaluacion->id_estado == 3){
                        $buscaResultado = Resultado::find()->where(['and',['id_evaluacion' => $postulacion->evaluacion->id_evaluacion],['id_estado' => 3]])->one();
                        if($buscaResultado != null){
                            $cont ++;
                        }else{
                            $buscaResultado2 = Resultado::find()->where(['and',['id_evaluacion' => $postulacion->evaluacion->id_evaluacion],['id_estado' => 2]])->one();
                            if($buscaResultado2 != null){
                                if($postulacion->montoAsignado != null){
                                    $cont++;
                                }

                            }
                        }

                    }
                }
            }    
               return $cont;
            },
            ],                                     

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{publicar}',
            'buttons' => ['publicar'=>function($url,$model,$key){
                return Html::a('<span class="fa fa-share-square"></span>',
['/convocatoria/publicacion','id_convocatoria' => $model->id_convocatoria],['title' => Yii::t('yii', 'Publicar resultados'),'aria-label' => Yii::t('yii', 'Publicar resultados'), 'class' => 'btn btn-primary','data-pjax' => '0',] );

        },



            ],
            ],
        ],
    ]); ?>

<?php Pjax::end(); ?>
    </div>
</div>

