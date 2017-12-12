<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use backend\models\Tipoarchivo;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AdjuntoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<?php

?>
<div class="adjunto-index">
<div  class="row">
    <div class="col-lg-12">
    <?php
        $request = Yii::$app->request;
        $id_tipoArchivo = $request->get('id_tipoArchivo');
        $buscaTipoArchivo = Tipoarchivo::find()->where(['id_tipoArchivo' => $id_tipoArchivo])->one();
        echo $buscaTipoArchivo->nombre_tipoArchivo;
     ?>    
    </div>
</div>
<br>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
            }
            ],
     
            [
                'attribute' => 'fecha_subida',
                'headerOptions' => ['class' => 'text-center'],
                'label'=>'Fecha de subida:',
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function($data){
                    return date('d-m-Y',strtotime($data->fecha_subida));
            }
            ],

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{download}',
            'buttons' => ['download'=>function($url,$model,$key){
                return Html::a('<span class="glyphicon glyphicon-cloud-download"></span>',

['/adjunto/download','id_adjunto' => $model->id_adjunto,'id_postulacion'=>Yii::$app->request->get('id_postulacion')],['title' => Yii::t('yii', 'Descargar'), 'aria-label' => Yii::t('yii', 'Descargar'), 'class' => 'btn btn-primary', 'data-pjax' => '0',] );
            },

            ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
