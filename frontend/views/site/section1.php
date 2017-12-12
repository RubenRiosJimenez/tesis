<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use himiklab\ckeditor\CKEditor;
use kartik\date\DatePicker;
//use kartik\widgets\Growl;

/* @var $this yii\web\View */
?>

<script src="../web/js/jquery.rut.js"></script>

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
    'start_step' => 1, // Optional, start with a specific step
];
?>
<?= \drsdre\wizardwidget\WizardWidget::widget($wizard_config); ?>


<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-10" style="color:#2D586C;">
Recuerde apretar el botón guardar cuando termine de llenar los campos de este formulario.
        </div>
<br>
<br>
        <div class="col-lg-5">
                <?= $form->field($model, 'nombre_organizacion')->textInput(['style'=>'height:1%;']); ?>
                <?= $form->field($model, 'rut_organizacion')->textInput(['id' => 'rut_organizacion','style'=>'height:1%;']); ?>
                <?= $form->field($model, 'numero_personalidadJuridica')->textInput(['style'=>'height:1%;']); ?>

                <?php

    
                    echo $form->field($model, 'fecha_personalidadJuridica')->widget(DatePicker::classname(), [
                    'pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                     'autoclose'=>true
                     ]
                    ]);
                
                  
                ?>

                <?= $form->field($model, 'organismoQueOtorgo_personalidadJuridica')->textInput(['style'=>'height:1%;']); ?>
        </div>
         <div class="col-lg-5">
                <?= $form->field($model, 'nombre_representanteLegal')->textInput(['style'=>'height:1%;','placeholder' => 'Nombres y Apellidos']); ?>
                <?= $form->field($model, 'telefono_contacto')->textInput(['style'=>'height:1%;','maxlength'=>9,'placeholder' => 'Ejemplo: Cel: 987432213 ó Fono: 422312456']); ?>
                <?= $form->field($model, 'numeroRut_representanteLegal')->textInput(['id' => 'numeroRut_representanteLegal','style'=>'height:1%;']); ?>
                <?= $form->field($model, 'domiciolio_representanteLegal')->textInput(['style'=>'height:1%;']); ?>
        </div>
    </div>
    <?= 
        $form->field($model, 'objetivos_generalesOrganizacion')->widget(CKEditor::className(), ['editorOptions' => ['height' => '250px', 'width'=>'600px','toolbarSet'=>'Basic',]]);   
    ?>  
    <br>
    <?= 
        $form->field($model, 'financiamiento_organizacion')->widget(CKEditor::className(), ['editorOptions' => ['height' => '250px', 'width'=>'600px','toolbarSet'=>'Basic',]]);   

        ?>  

   
   <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary'])
         ?>

        <?= Html::a('Siguiente',

            ['/site/section2',
            'id_postulacion' => $model->id_postulacion
            ],
            ['class'=> 'btn btn-default', 'style'=>'float:right', 'title' => Yii::t('yii', 'Siguiente'), 'aria-label' => Yii::t('yii', 'Siguiente'), 'data-pjax' => '0',

            ] 

        );?>
    </div>

<?php ActiveForm::end(); ?>


<script type="text/javascript">
    
$("input#rut_organizacion").rut({
    formatOn: 'keyup'
});

$("input#numeroRut_representanteLegal").rut({
    formatOn: 'keyup'
});

</script>