<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\FormularioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
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
    'start_step' => 4, // Optional, start with a specific step
];
?>
<?= \drsdre\wizardwidget\WizardWidget::widget($wizard_config); ?>

<div class="tablapresupuesto-index">
<div style="overflow: auto;">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'descripcion',
            //'cantidad',
            //'precioUnitario',
            //'costoTotal',

            [
                'attribute' => 'descripcion',
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
                'label'=>'Descripción',
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name', 'style' => 'max-width: 300px; word-wrap: break-word;'];
            },

            'value'=>function ($data) {
               return $data->descripcion; 
            }
            ],

            [
                'attribute' => 'cantidad',
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
                'label'=>'Cantidad',
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function ($data) {
               return $data->cantidad; 
            }
            ],

            [
                'attribute' => 'precioUnitario',
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
                'label'=>'Precio unitario ($)',
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function ($data) {
               return '$ '.number_format($data->precioUnitario, 0, ",", "."); 
            }
            ],

             [
                'attribute' => 'costoTotal',
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
                'label'=>'Costo total ($)',
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function ($data) {
               return '$ '.number_format($data->costoTotal, 0, ",", "."); 
            }
            ],                                   



            ['class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'buttons' => ['update'=>function($url,$model,$key){
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>',

['/tablapresupuesto/update','id_tabla_presupuesto' => $model->id_tabla_presupuesto,'id_postulacion'=>Yii::$app->request->get('id_postulacion')],['title' => Yii::t('yii', 'Modificar presupuesto'), 'aria-label' => Yii::t('yii', 'Modificar presupuesto'), 'class'=>'btn btn-primary inline1-1', 'data-pjax' => '0',] );
            },

'delete'=>function($url,$model,$key){
                return Html::a('<span class="glyphicon glyphicon-trash"></span>',

['/tablapresupuesto/delete','id_tabla_presupuesto' => $model->id_tabla_presupuesto,'id_postulacion'=> Yii::$app->request->get('id_postulacion')],['title' => Yii::t('yii', 'Eliminar presupuesto'),'aria-label' => Yii::t('yii', 'Eliminar presupuesto'), 'class'=>'btn btn-danger', 'data-confirm' => Yii::t('yii', '¿Estas seguro que deseas eliminar este presupuesto?'),'data-method' => 'post','data-pjax' => '0',] );
            },

            ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
<br>

    <div  class="row">
       
      <div class="col-lg-12">
        <?php 

        if($this->params['customParam']==0){
             echo '';
        }else{
             $this->params['customParam'] = '$ '.number_format($this->params['customParam'], 0, ",", ".");
             echo '<h4>Presupuesto total del proyecto: '.$this->params['customParam'].'</h4>';
        }
           
        ?>



     </div>

    </div>
     <?= Html::a('Siguiente',

            ['/site/section5',
            'id_postulacion' => $model->id_postulacion
            ],
            ['class'=> 'btn btn-default', 'style'=>'float:right', 'title' => Yii::t('yii', 'Siguiente'), 'aria-label' => Yii::t('yii', 'Siguiente'), 'data-pjax' => '0',

            ] 

        );?>
        <?= Html::a('Volver',

            ['/site/section3',
            'id_postulacion' => $model->id_postulacion
            ],
            ['class'=> 'btn btn-default', 'style'=>'float:right; margin-right:5%;', 'title' => Yii::t('yii', 'Volver'), 'aria-label' => Yii::t('yii', 'Volver'), 'data-pjax' => '0',

            ] 

        );?>
    <p>
        <?php $id_formulario=$model->id_formulario;?>
        <?= Html::a('Agregar presupuesto', ['/tablapresupuesto/create','id_formulario'=> $id_formulario, 'id_postulacion'=> $id_postulacion],['id'=>'inline1-0', 'class' => 'btn btn-success']) ?>

    </p>
    
</div>

        <script>
            $(document).ready(function(){
                $("#inline1-0").colorbox({innerWidth:'70%', innerHeight:'80%'});
                $(".inline1-1").colorbox({innerWidth:'70%', innerHeight:'80%'});
            });
        </script>