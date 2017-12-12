<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Adjunto;
use backend\models\Tipoarchivo;
use backend\models\Formulario;
use backend\models\Postulacion;
use backend\models\Concursante;
use yii\helpers\Url;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
$this->title = 'Documentos:';
?>
<?php

 $request = Yii::$app->request;
 $id_postulacion = $request->get('id_postulacion');
 $buscaPostulacion = Postulacion::find()->where(['id_postulacion' => $id_postulacion])->one();
 $buscaConcursante = Concursante::find()->where(['id_concursante' => $buscaPostulacion->id_concursante])->one();
?>
 


<div class="adjunto-index">
    <br>
    <div class="row">
        <div class="col-lg-12">
            <strong>Documentación del concursante <?= Html::encode($buscaConcursante->nombreConcursante) ?></strong>
        </div>
    </div>
    
    <br>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'format' => 'html',
                'attribute' => 'nombre_tipoArchivo',
                'headerOptions' => ['class' => 'text-center'],
                'label'=>'Documentos:',
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name'];
            },

            'value'=>function ($data) {
               return $data->nombre_tipoArchivo; 
            }
            ],

            [
                'label'=>'Cantidad de documentos',
                'headerOptions' => ['class' => 'text-center'],
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function ($data) {

                $id_postulacion=Yii::$app->request->get('id_postulacion');
                $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();
                $adjunto= Adjunto::find()->where(['and',['id_formulario' =>$buscaFormulario->id_formulario],['id_tipoArchivo'=>$data->id_tipoArchivo]])->count();
               return $adjunto;
            },
            ],         

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{buscar}',
            'buttons' => ['buscar'=>function($url,$model,$key){
                return Html::button('<span class="glyphicon glyphicon-search"></span>', ['value'=>Url::to(['/adjunto/documentacion','id_tipoArchivo' => $model->id_tipoArchivo, 'id_postulacion'=>Yii::$app->request->get('id_postulacion')]), 'class' => 'btn btn-success modalButton-4']);
            },
            

            ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>

<?= Html::a('Volver',

            ['/postulacion/index'],
            ['class'=> 'btn btn-default', 'style'=>'float:right', 'title' => Yii::t('yii', 'Volver'), 'aria-label' => Yii::t('yii', 'Volver'), 'data-pjax' => '0',

            ] 

        );?>
 <br>
<br>
</div>


    <?php
        Modal::begin([
                'header'=>'<h3>Documentos:<h3>',
                'id' => 'modal-4',
                'size' => 'modal-lg',
            ]);
        echo "<div id='modalContent-4'></div>";

        Modal::end();
    ?>
