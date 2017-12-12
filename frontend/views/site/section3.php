<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use himiklab\ckeditor\CKEditor;

/* @var $this yii\web\View */
?>

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
    'start_step' => 3, // Optional, start with a specific step
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
                <?= $form->field($model, 'nombre_proyecto')->textInput(['style'=>'height:1%;']); ?>
                <?= $form->field($model, 'numero_unidadVecinal')->textInput(['style'=>'height:1%;']); ?>
                <?= $form->field($model, 'direccion_proyecto')->textInput(['style'=>'height:1%;']); ?>
        </div>
         <div class="col-lg-5">
                <?= $form->field($model, 'numero_beneficiariosDirectos')->textInput(['maxlength'=>9,'style'=>'height:1%; width:50%;']); ?>
                <?= $form->field($model, 'numero_beneficiariosIndirectos')->textInput(['maxlength'=>9,'style'=>'height:1%; width:50%;']); ?>
        </div>
    </div>
        <?= 
        $form->field($model, 'descripcion_beneficiariosDirectos')->widget(CKEditor::className(), ['editorOptions' => ['height' => '250px', 'width'=>'600px','toolbarSet'=>'Basic',]]);   
        ?> 
    <br>
        <?= 
        $form->field($model, 'objetivos_proyecto')->widget(CKEditor::className(), ['editorOptions' => ['height' => '250px', 'width'=>'600px','toolbarSet'=>'Basic',]]);   
    ?> 
    <br> 
    <?= 
        $form->field($model, 'descripcion_proyecto')->widget(CKEditor::className(), ['editorOptions' => ['height' => '250px', 'width'=>'600px','toolbarSet'=>'Basic',]]);   
        ?>  
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Siguiente',

            ['/site/section4',
            'id_postulacion' => $model->id_postulacion
            ],
            ['class'=> 'btn btn-default', 'style'=>'float:right', 'title' => Yii::t('yii', 'Siguiente'), 'aria-label' => Yii::t('yii', 'Siguiente'), 'data-pjax' => '0',

            ] 

        );?>
        <?= Html::a('Volver',

            ['/site/section2',
            'id_postulacion' => $model->id_postulacion
            ],
            ['class'=> 'btn btn-default', 'style'=>'float:right; margin-right:5%;', 'title' => Yii::t('yii', 'Volver'), 'aria-label' => Yii::t('yii', 'Volver'), 'data-pjax' => '0',

            ] 

        );?>
    </div>
<?php ActiveForm::end(); ?>