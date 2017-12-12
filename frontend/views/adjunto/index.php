<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\models\Tipoarchivo;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AdjuntoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Documentos:';
?>

<?php

 $request = Yii::$app->request;
 $id_tipoArchivo = $request->get('id_tipoArchivo');
?>

<div class="adjunto-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <div  class="row">
    <div class="col-lg-12">
    <?php
        $buscaTipoArchivo = Tipoarchivo::find()->where(['id_tipoArchivo' => $id_tipoArchivo])->one();
        echo $buscaTipoArchivo->nombre_tipoArchivo; 
     ?>    
    </div>
</div>
<br>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'nombre_original',
            //'fecha_subida',

            [
                'format' => 'html',
                'attribute' => 'nombre_original',
                'headerOptions' => ['class' => 'text-center'],
                'label'=>'Nombre del documento:',
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name'];
            },

            'value'=>function ($data) {
               return $data->nombre_original; 
               //return Html::a($data->nombre_original, ['/adjunto/download', 'id_adjunto' => $data->id_adjunto]);
            }
            ],
     
            [//'format' => 'date',
                'attribute' => 'fecha_subida',
                'headerOptions' => ['class' => 'text-center'],
                'label'=>'Fecha de subida:',
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function($data){
                    //setlocale(LC_ALL, 'es_ES');
                    return date('d-m-Y',strtotime($data->fecha_subida));
                    //return $data->fecha_subida; 
            }
            ],

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{download} {delete}',
            'buttons' => ['download'=>function($url,$model,$key){
                return Html::a('<span class="glyphicon glyphicon-cloud-download"></span>',

['/adjunto/download','id_adjunto' => $model->id_adjunto,'id_postulacion'=>Yii::$app->request->get('id_postulacion')],['title' => Yii::t('yii', 'Descargar documento'), 'aria-label' => Yii::t('yii', 'Descargar documento'), 'class'=>'btn btn-primary', 'data-pjax' => '0',] );
            },

'delete'=>function($url,$model,$key){
                return Html::a('<span class="glyphicon glyphicon-trash"></span>',

['/adjunto/delete','id_adjunto' => $model->id_adjunto,'id_postulacion'=>Yii::$app->request->get('id_postulacion')],['title' => Yii::t('yii', 'Eliminar documento'),'aria-label' => Yii::t('yii', 'Eliminar documento'), 'class'=>'btn btn-danger', 'data-confirm' => Yii::t('yii', '¿Estas seguro que deseas eliminar este documento?'),'data-method' => 'post','data-pjax' => '0',] );
            },

            ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>