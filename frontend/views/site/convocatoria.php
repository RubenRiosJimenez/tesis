<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use frontend\models\Postulacion;
use frontend\models\Concursante;
use backend\models\fondo;


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ConvocatoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model backend\models\Fondo */

$this->title = 'Convocatorias';
?>
<div class="convocatoria-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
<div class='row'>
    <div class="col-lg-8">
        Para postular a una convocatoria deberá completar un formulario.
    </div>
</div>
    <div style="overflow: auto;">
<?php Pjax::begin(); ?>   

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id_convocatoria',
           // 'id_estadoConvocatoria',
            //'nombreConvocatoria',
            //'fecha_inicio',
            //'fecha_termino',


            [
                'attribute' => 'nombreConvocatoria',
                'label'=>'Convocatoria',
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },

            'value'=>function ($data) {
               return $data->nombreConvocatoria; 
            },
            ],

            [
                'attribute'=>'nombreFondo',
                'label'=>'Fondo',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name', 'style' => 'max-width: 300px; word-wrap: break-word;'];
                },

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
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function ($data) {
               return date('d-m-Y',strtotime($data->fecha_inicio));
            },
            ],


            [
                'attribute' => 'fecha_termino',
                'label'=>'Fecha de término',
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function ($data) {
               return date('d-m-Y',strtotime($data->fecha_termino)); 
            },
            ],                                    

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{postular}',
            'buttons' => ['postular'=>function($url,$model,$key){
                $id_usuario__actual=\Yii::$app->user->id;
                $concursante_actual= Concursante::find()->where(['id' =>$id_usuario__actual])->one();
                $obtieneid_concursante=$concursante_actual->id_concursante;
                $buscaPostulacion = Postulacion::find()->where(['and',['id_convocatoria'=>$model->id_convocatoria],['id_concursante'=>  $obtieneid_concursante]])->one(); 
                if($buscaPostulacion==null){
                     return Html::a('Postular',['/site/postular','id_convocatoria' => $model->id_convocatoria],
   ['class'=> 'btn btn-success', 'title' => Yii::t('yii', 'Postular'), 'aria-label' => Yii::t('yii', 'Postular'), 'data-pjax' => '0',]);
                }else{

                    if($buscaPostulacion->id_estadopostulacion==1||$buscaPostulacion->id_estadopostulacion==3) return Html::a('Editar postulación',['/site/postular','id_convocatoria' => $model->id_convocatoria],
   ['class'=> 'btn btn-warning', 'title' => Yii::t('yii', 'Editar postulación'), 'aria-label' => Yii::t('yii', 'Editar postulación'), 'data-pjax' => '0',]);
                    
                    if($buscaPostulacion->id_estadopostulacion==2) /*return Html::a('Postulación enviada','#',
   ['title' => Yii::t('yii', 'Postulación enviada'), 'aria-label' => Yii::t('yii', 'Postulación enviada'), 'data-pjax' => '0',]);*/
                        return Html::tag('span', '&nbsp;&nbsp;Postulación enviada&nbsp;&nbsp;', ['class' => 'label label-primary', 'style'=>' font-size: 12px;']);
                    


                }
               
            },

            ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
</div>

