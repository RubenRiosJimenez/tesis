<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
?>
<link rel="stylesheet" href="../web/css/colorbox.css" />
<script src="../web/js/jquery.colorbox.js"></script>
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
    'start_step' => 6, // Optional, start with a specific step
];
?>
<?= \drsdre\wizardwidget\WizardWidget::widget($wizard_config); ?>

<div class="tablacartagantt-index">
<div style="overflow: auto;">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'mes',
                'label' => 'Mes',
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function ($data) {
               return $data->mes; 
            },
            ],
            
            ['format' => 'html',
                'attribute' => 'descripcion',
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
                'label'=>'Descripción',
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },

            'value'=>function ($data) {
               return $data->descripcion; 
            },
            ],

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'buttons' => ['update'=>function($url,$model,$key){
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>',

['/tablacartagantt/update','id_tabla_cartaGantt' => $model->id_tabla_cartaGantt, 'id_postulacion'=>Yii::$app->request->get('id_postulacion')],['title' => Yii::t('yii', 'Modificar actividad'), 'aria-label' => Yii::t('yii', 'Modificar actividad'), 'class'=>'btn btn-primary inline3-1', 'data-pjax' => '0',] );
            },

'delete'=>function($url,$model,$key){
                return Html::a('<span class="glyphicon glyphicon-trash"></span>',

['/tablacartagantt/delete','id_tabla_cartaGantt' => $model->id_tabla_cartaGantt, 'id_postulacion'=>Yii::$app->request->get('id_postulacion')],['title' => Yii::t('yii', 'Eliminar actividad'),'aria-label' => Yii::t('yii', 'Eliminar actividad'), 'class'=>'btn btn-danger', 'data-confirm' => Yii::t('yii', '¿Estas seguro que deseas eliminar esta tarea?'),'data-method' => 'post','data-pjax' => '0',] );
            },

            ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
<br>

      <?= Html::a('Siguiente',

            ['/site/section7',
            'id_postulacion' => $model->id_postulacion
            ],
            ['class'=> 'btn btn-default', 'style'=>'float:right', 'title' => Yii::t('yii', 'Siguiente'), 'aria-label' => Yii::t('yii', 'Siguiente'), 'data-pjax' => '0',

            ] 

        );?>
        <?= Html::a('Volver',

            ['/site/section5',
            'id_postulacion' => $model->id_postulacion
            ],
            ['class'=> 'btn btn-default', 'style'=>'float:right; margin-right:5%;', 'title' => Yii::t('yii', 'Volver'), 'aria-label' => Yii::t('yii', 'Volver'), 'data-pjax' => '0',

            ] 

        );?>
    <p>
        <?php $id_formulario=$model->id_formulario;?>
        <?= Html::a('Agregar actividad', ['/tablacartagantt/create','id_formulario'=> $id_formulario, 'id_postulacion'=> $id_postulacion],['id'=>'inline3-0', 'class' => 'btn btn-success']) ?>

    </p>
    
</div>

        <script>
            $(document).ready(function(){
                $("#inline3-0").colorbox({innerWidth:'80%', innerHeight:'90%'});
                $(".inline3-1").colorbox({innerWidth:'80%', innerHeight:'90%'});               
            });
        </script>