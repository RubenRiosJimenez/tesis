<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\models\Adjunto;
use frontend\models\Tipoarchivo;
use frontend\models\Formulario;


/* @var $this yii\web\View */
?>
<link rel="stylesheet" href="../web/css/colorbox.css" />
<script src="../web/js/jquery.colorbox2.js"></script>
<?php

 $request = Yii::$app->request;
 $id_postulacion = $request->get('id_postulacion');

$wizard_config = [
    'id' =>  $id_postulacion,
    'steps' => [
    
        1 => [
            'title' => 'Antecedentes generales de la organización',
            'icon' => 'glyphicon glyphicon-user',
            'content' => '<h3>Antecedentes generales de la organización y del representante legal:</h3> <hr>',
             /*'buttons' => [
                'next' => [
                    'html' => '<a class="btn btn-primary" href="'.Yii::$app->request->baseUrl.'/index.php?r=site/section2'.'">Siguiente</a>', 
                 ],
             ],*/
        ],
        
        2 => [
            'title' => 'Área a la que destinará la subvención',
            'icon' => 'glyphicon glyphicon-edit',
            'content' => '<h3>Área a la que destinará la subvención:</h3> <hr>',
        ],
        
        3 => [
            'title' => 'Características del proyecto',
            'icon' => 'glyphicon glyphicon-briefcase',
            'content' => '<h3>Características del proyecto:</h3> <hr>',
        ],
        
        4 => [
            'title' => 'Presupuesto del proyecto',
            'icon' => 'glyphicon glyphicon-piggy-bank',
            'content' => '<h3>Presupuesto detallado del proyecto:</h3> <hr>',
        ],

        5 => [
            'title' => '¿Qué financiará con la subvención municipal?',
            'icon' => 'glyphicon glyphicon-list-alt',
            'content' => '<h3>¿Qué financiará con la subvención municipal?</h3> <hr>',
        ],  

        6 => [
            'title' => 'Carta GANTT del proyecto',
            'icon' => 'glyphicon glyphicon-indent-left',
            'content' => '<h3>Carta GANTT del proyecto:</h3> <hr>',
        ], 
        7 => [
            'title' => 'Documentos solicitados',
            'icon' => 'glyphicon glyphicon-cloud-upload',
            'content' => '<h3>Documentos solicitados:</h3> <hr>',
        ],                  
    ],

    'complete_content' => "Revisión y envío:", // Optional final screen
    'start_step' => 7, // Optional, start with a specific step
];
?>
<?= \drsdre\wizardwidget\WizardWidget::widget($wizard_config); ?>
<?php $id_formulario= $model->id_formulario;?>
 
<div class='row'>
    <div class="col-lg-12">
        <h4>Cartas tipo de referencia:</h4>
        <br>
        <ul>
        <li><a href="../web/documentos/cartatipo1.docx">&#8226; Carta de presentación y solicitud de financiamiento dirigida al Sr. Alcalde.</a></li>

        <li><a href="../web/documentos/cartatipo2.docx">&#8226; Carta de compromiso del representante legal que señala los aportes del proyecto.</a></li>

        <li><a href="../web/documentos/cartatipo3.docx">&#8226; Carta de compromiso de rendir cuenta documentada de los montos otorgados.</a></li>
        </ul>
        <br>
        Debe adjuntar los siguientes documentos:
    </div>
</div>


<div class="adjunto-index">
    
    <br>
        <div style="overflow: auto;">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'format' => 'html',
                'attribute' => 'nombre_tipoArchivo',
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
                'label'=>'Documentos',
                'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name'];
            },

            'value'=>function ($data) {
               return $data->nombre_tipoArchivo; 
            }
            ],





            [
                //'attribute' => 'fecha_inicio',
                'label'=>'Cantidad de documentos',
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function ($data) {

                $id_postulacion=Yii::$app->request->get('id_postulacion');
                $buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one();
                $adjunto= Adjunto::find()->where(['and',['id_formulario' => $buscaFormulario->id_formulario],['id_tipoArchivo'=>$data->id_tipoArchivo]])->count();
               return $adjunto;
            },
            ],




            ['class' => 'yii\grid\ActionColumn',
            'template' => '{subir} {buscar}',
            'options'=> ['style'=>'min-width:150px;'],
            'buttons' => ['subir'=>function($url,$model,$key){
                return Html::a('<span class="glyphicon glyphicon-upload"></span>',

['/adjunto/create','id_tipoArchivo' => $model->id_tipoArchivo, 'id_postulacion'=>Yii::$app->request->get('id_postulacion')],['title' => Yii::t('yii', 'Subir documentos'), 'aria-label' => Yii::t('yii', 'Subir documentos'), 'class'=>'btn btn-success inline4-0', 'data-pjax' => '0',] );
            },

'buscar'=>function($url,$model,$key){
                return Html::a('<span class="glyphicon glyphicon-search"></span>',

['/adjunto/index','id_tipoArchivo' => $model->id_tipoArchivo, 'id_postulacion'=>Yii::$app->request->get('id_postulacion')],['title' => Yii::t('yii', 'Ver documentos'), 'aria-label' => Yii::t('yii', 'Ver documentos'), 'class'=>'btn btn-primary inline4-1', 'data-pjax' => '0',] );
            },

            ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>

        <?= Html::a('Siguiente',

            ['/site/section8',
            'id_postulacion' => $model->id_postulacion
            ],
            ['class'=> 'btn btn-default', 'style'=>'float:right', 'title' => Yii::t('yii', 'Siguiente'), 'aria-label' => Yii::t('yii', 'Siguiente'), 'data-pjax' => '0',

            ] 

        );?>
        <?= Html::a('Volver',

            ['/site/section6',
            'id_postulacion' => $model->id_postulacion
            ],
            ['class'=> 'btn btn-default', 'style'=>'float:right; margin-right:5%;', 'title' => Yii::t('yii', 'Volver'), 'aria-label' => Yii::t('yii', 'Volver'), 'data-pjax' => '0',

            ] 

        );?>
    
    <br>
    <br>
    </div>
</div>

        <script>
            $(document).ready(function(){
                $(".inline4-0").colorbox({innerWidth:'80%', innerHeight:'80%'}); 
                $(".inline4-1").colorbox({innerWidth:'80%', innerHeight:'80%'}); 
            });
        </script>