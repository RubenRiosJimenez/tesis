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
    'start_step' => 2, // Optional, start with a specific step
];
?>
<?= \drsdre\wizardwidget\WizardWidget::widget($wizard_config); ?>


<script src="../../vendor/ckeditor/ckeditor/ckeditor.js" type='text/javascript'></script>


<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-10" style="color:#2D586C;">
Recuerde apretar el botón guardar luego de seleccionar el área en la cuál se destinará la subvención.
        </div>
<br>
<br>
        <div class="col-lg-5">
           <ul>
                <li>
                    <?php

                    if($model->area_subvencion=='Asistencia Social'){
                        $seleccionado=true;
                    }else{
                        $seleccionado=false;
                    } 
                    ?>
                   <?= Html::radio('area_subvencion',$seleccionado,['label' => 'Asistencia Social', 'value' => 'Asistencia Social', 'onclick'=>'hideoff()']) ?>
               </li>
                <li>
                    <?php

                    if($model->area_subvencion=='Educación'){
                        $seleccionado=true;
                    }else{
                        $seleccionado=false;
                    } 
                    ?>

                    <?= Html::radio('area_subvencion',$seleccionado,['label' => 'Educación', 'value' => 'Educación', 'onclick'=>'hideoff()']) ?>


                </li>
                <li>
                    <?php

                    if($model->area_subvencion=='Protección del medio ambiente'){
                        $seleccionado=true;
                    }else{
                        $seleccionado=false;
                    } 
                    ?>
                    <?= Html::radio('area_subvencion',$seleccionado,['label' => 'Protección del medio ambiente', 'value' => 'Protección del medio ambiente', 'onclick'=>'hideoff()']) ?>


                </li>


                <li>
                    <?php

                    if($model->area_subvencion=='Cultura'){
                        $seleccionado=true;
                    }else{
                        $seleccionado=false;
                    } 
                    ?>
                    <?= Html::radio('area_subvencion',$seleccionado,['label' => 'Cultura', 'value' => 'Cultura', 'onclick'=>'hideoff()']) ?>

                </li>
                <li>
                    <?php

                    if($model->area_subvencion=='Salud Pública'){
                        $seleccionado=true;
                    }else{
                        $seleccionado=false;
                    } 
                    ?>

                    <?= Html::radio('area_subvencion',$seleccionado,['label' => 'Salud Pública', 'value' => 'Salud Pública', 'onclick'=>'hideoff()']) ?>

                </li>


            </ul>
        </div>
        <div class="col-lg-5">
        <ul>
            <li>


            <?php

            if($model->area_subvencion=='Capacitación y promoción del empleo'){
                $seleccionado=true;
            }else{
                $seleccionado=false;
            } 
            ?>
            <?= Html::radio('area_subvencion',$seleccionado,['label' => 'Capacitación y promoción del empleo', 'value' => 'Capacitación y promoción del empleo', 'onclick'=>'hideoff()']) ?>

            </li>

            <li>
            <?php

            if($model->area_subvencion=='Deporte y Recreación'){
                $seleccionado=true;
            }else{
                $seleccionado=false;
            } 
            ?>
            <?= Html::radio('area_subvencion',$seleccionado,['label' => 'Deporte y Recreación', 'value' => 'Deporte y Recreación', 'onclick'=>'hideoff()']) ?>

            </li>
            <li>

            <?php

            if($model->area_subvencion=='Turismo'){
                $seleccionado=true;
            }else{
                $seleccionado=false;
            } 
            ?>

            <?= Html::radio('area_subvencion',$seleccionado,['label' => 'Turismo', 'value' => 'Turismo', 'onclick'=>'hideoff()']) ?>

            </li>
            <li>

            <?php

            if($model->area_subvencion=='Otra'){
                $seleccionado=true;
            }else{
                $seleccionado=false;
            } 
            ?>           
            <?= Html::radio('area_subvencion',$seleccionado,['label' => 'Otra', 'value' => 'Otra', 'onclick'=>'hideon()']) ?>

            </li>
        



        </ul>



            
        </div>
    </div>
    <?php
    if($model->area_subvencion=='Otra'){
    echo '<div id="hidde">';
    }else{
    echo '<div id="hidde" style="display: none;">';
    }
    ?>
        <?= 
         $form->field($model, 'otra_subvencion')->widget(CKEditor::className(), [/*'options' => ['readonly'=>true,],*/ 'editorOptions' => ['height' => '250px', 'width'=>'600px','toolbarSet'=>'Basic',]]);   
        ?> 
    </div> 
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>

        <?= Html::a('Siguiente',

            ['/site/section3',
            'id_postulacion' => $model->id_postulacion
            ],
            ['class'=> 'btn btn-default', 'style'=>'float:right', 'title' => Yii::t('yii', 'Siguiente'), 'aria-label' => Yii::t('yii', 'Siguiente'), 'data-pjax' => '0',

            ] 

        );?>
        <?= Html::a('Volver',

            ['/site/section1',
            'id_postulacion' => $model->id_postulacion
            ],
            ['class'=> 'btn btn-default', 'style'=>'float:right; margin-right:5%;', 'title' => Yii::t('yii', 'Volver'), 'aria-label' => Yii::t('yii', 'Volver'), 'data-pjax' => '0',

            ] 

        );?>
    </div>

<?php ActiveForm::end(); ?>
<!--
<script>
        var editor;
        CKEDITOR.on( 'instanceReady', function ( ev ) {
            editor = ev.editor;
        } );
        function toggleReadOnly( isReadOnly ) {
            editor.setReadOnly( isReadOnly );
            if(isReadOnly != false)
                editor.setData('');
        }
</script>
-->
<script>
        function hideon() {
            $('#hidde').show();
        }
</script>

<script>
        var editor;
        CKEDITOR.on( 'instanceReady', function ( ev ) {
            editor = ev.editor;
        } );
        function hideoff() {
            editor.setData('');
            $('#hidde').hide();
        }
</script>