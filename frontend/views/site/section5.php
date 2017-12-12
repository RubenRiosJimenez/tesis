<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
    'start_step' => 5, // Optional, start with a specific step
];
?>
<?= \drsdre\wizardwidget\WizardWidget::widget($wizard_config); ?>

<div class="tablaitemfinanciamiento-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="col-lg-10" style="color:#2D586C;">
Recuerde apretar el botón guardar cuando termine de llenar los campos de este formulario.
        </div>
<br>
<br>    
  <div style="overflow: auto;">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'descripcion',
            //'monto',

            [
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

            [
                'attribute' => 'monto',
                'headerOptions' => ['class' => 'text-center', 'style' => 'font-weight: bold'],
                'label'=>'Monto ($)',
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function ($data) {
            return '$ '.number_format($data->monto, 0, ",", ".");
            },
            ],

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'options'=> ['style'=>'min-width:110px;'],
            'buttons' => ['update'=>function($url,$model,$key){
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>',

['/tablaitemfinanciamiento/update','id_tabla_item_financiamiento' => $model->id_tabla_item_financiamiento, 'id_postulacion'=>Yii::$app->request->get('id_postulacion')],['title' => Yii::t('yii', 'Modificar financiamiento'), 'aria-label' => Yii::t('yii', 'Modificar'), 'class'=>'btn btn-primary inline2-1', 'data-pjax' => '0',] );
            },

'delete'=>function($url,$model,$key){
                return Html::a('<span class="glyphicon glyphicon-trash"></span>',

['/tablaitemfinanciamiento/delete','id_tabla_item_financiamiento' => $model->id_tabla_item_financiamiento, 'id_postulacion'=>Yii::$app->request->get('id_postulacion')],['title' => Yii::t('yii', 'Eliminar financiamiento'),'aria-label' => Yii::t('yii', 'Eliminar financiamiento'), 'class'=>'btn btn-danger', 'data-confirm' => Yii::t('yii', '¿Estas seguro que deseas eliminar este financiamiento?'),'data-method' => 'post','data-pjax' => '0',] );
            },

            ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
        <p>
        <?php $id_formulario=$model->id_formulario;?>
        <?= Html::a('Agregar financiamiento', ['/tablaitemfinanciamiento/create','id_formulario'=> $id_formulario, 'id_postulacion'=> $id_postulacion],['id'=>'inline2-0', 'class' => 'btn btn-success']) ?>

    </p>
</div>
     <br>
<h3>Financiamiento del proyecto:</h3>
<hr>
<?php $form = ActiveForm::begin(); ?>
</div>
<br>
    <div class="row">
        <div class="col-lg-12">
        Recuerde que el aporte total del proyecto debe ser igual al total del presupuesto ingresado en la etapa anterior.
        <br>
        <br>
        <br>
        </div>

        <div class="col-lg-3">
                <?= $form->field($model, 'financiamiento_aporte_propio')->textInput(['maxlength'=>9, 'style'=>'height:1%;']); ?>
                <?= $form->field($model, 'financiamiento_aporte_terceros')->textInput(['maxlength'=>9,'style'=>'height:1%;']); ?>
        </div>
         <div class="col-lg-3">
         <?php
                $model->financiamiento_aporte_solicitado = '$ '.number_format($model->financiamiento_aporte_solicitado, 0, ",", ".");
                $model->financiamiento_aporteTotal_proyecto = '$ '.number_format($model->financiamiento_aporteTotal_proyecto, 0, ",", ".");
                ?>
                <?= $form->field($model, 'financiamiento_aporte_solicitado')->textInput(['readonly' => 'true','style'=>'height:1%;']); ?>
                <?= $form->field($model, 'financiamiento_aporteTotal_proyecto')->textInput(['readonly' => 'true','style'=>'height:1%;']); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
           <?= Html::a('Siguiente',

            ['/site/section6',
            'id_postulacion' => $model->id_postulacion
            ],
            ['class'=> 'btn btn-default', 'style'=>'float:right', 'title' => Yii::t('yii', 'Siguiente'), 'aria-label' => Yii::t('yii', 'Siguiente'), 'data-pjax' => '0',

            ] 

        );?>
        <?= Html::a('Volver',

            ['/site/section4',
            'id_postulacion' => $model->id_postulacion
            ],
            ['class'=> 'btn btn-default', 'style'=>'float:right; margin-right:5%;', 'title' => Yii::t('yii', 'Volver'), 'aria-label' => Yii::t('yii', 'Volver'), 'data-pjax' => '0',

            ] 

        );?>
    </div>
<?php ActiveForm::end(); ?>

        <script>
            $(document).ready(function(){
                $("#inline2-0").colorbox({innerWidth:'70%', innerHeight:'70%'});
                $(".inline2-1").colorbox({innerWidth:'70%', innerHeight:'70%'});               
            });
        </script>