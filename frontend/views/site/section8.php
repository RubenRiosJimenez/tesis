<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use frontend\models\Tablapresupuesto;
use frontend\models\Tablaitemfinanciamiento;
use frontend\models\Tablacartagantt;
use frontend\models\Adjunto;





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

    'complete_content' => "<h3>Revisión y envío:</h3> <hr>", // Optional final screen
    'start_step' => 'completed', // Optional, start with a specific step
];
?>
<?= \drsdre\wizardwidget\WizardWidget::widget($wizard_config); ?>

<div class="row">


    <?php

    $presupuestoTotal = Tablapresupuesto::find()->where(['id_formulario' => $model->id_formulario])->all();

    $totalPresupuestoProyecto = 0;
    if($presupuestoTotal != null){
        foreach($presupuestoTotal as $totalPresupuesto){
            $totalPresupuestoProyecto = $totalPresupuestoProyecto + $totalPresupuesto->costoTotal;
        }
    }




    $tablapresupuesto= Tablapresupuesto::find()->where(['id_formulario' =>$model->id_formulario])->one();
    $tablaitemfinanciamiento= Tablaitemfinanciamiento::find()->where(['id_formulario' =>$model->id_formulario])->one();
    $tablacartagantt= Tablacartagantt::find()->where(['id_formulario' =>$model->id_formulario])->one();
    $adjuntotipoarchivouno= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>1]])->all();
    $adjuntotipoarchivodos= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>2]])->all();
    $adjuntotipoarchivotres= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>3]])->all();
    $adjuntotipoarchivocuatro= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>4]])->all();
    $adjuntotipoarchivocinco= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>5]])->all();
    $adjuntotipoarchivoseis= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>6]])->all();
    $adjuntotipoarchivosiete= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>7]])->all();
    $adjuntotipoarchivoocho= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>8]])->all();
    $adjuntotipoarchivodiez= Adjunto::find()->where(['and',['id_formulario' =>$model->id_formulario],['id_tipoArchivo'=>10]])->all();

    if($model->nombre_organizacion==''||$model->nombre_representanteLegal==''||$model->rut_organizacion==''||$model->telefono_contacto==''||$model->numero_personalidadJuridica==''||$model->numeroRut_representanteLegal==''||$model->fecha_personalidadJuridica==''||$model->domiciolio_representanteLegal==''||$model->organismoQueOtorgo_personalidadJuridica==''||$model->objetivos_generalesOrganizacion==''||$model->financiamiento_organizacion==''||$model->area_subvencion==''||($model->area_subvencion=='Otra'&&$model->otra_subvencion==''||$model->nombre_proyecto==''||$model->numero_beneficiariosDirectos==''||$model->numero_unidadVecinal==''||$model->numero_beneficiariosIndirectos==''||$model->direccion_proyecto==''||$model->descripcion_beneficiariosDirectos==''||$model->objetivos_proyecto==''||$model->descripcion_proyecto==''||$tablapresupuesto==null||$tablaitemfinanciamiento==null||$model->financiamiento_aporte_propio==''||$model->financiamiento_aporte_solicitado==''||$model->financiamiento_aporte_terceros==''||$model->financiamiento_aporteTotal_proyecto==''||$tablacartagantt==null||$adjuntotipoarchivouno==null||$adjuntotipoarchivodos==null||$adjuntotipoarchivotres==null||$adjuntotipoarchivocuatro==null||$adjuntotipoarchivocinco==null||$adjuntotipoarchivoseis==null||$adjuntotipoarchivosiete==null||$adjuntotipoarchivoocho==null || $adjuntotipoarchivodiez==null))
    {
        echo '<div class="col-lg-10"><h4>Para enviar su postulación debe llenar los siguientes campos que se encuentran vacíos:</h4></div>';


?>

<div class="col-lg-8">
<?php

            if($model->nombre_organizacion==''||$model->nombre_representanteLegal==''||$model->rut_organizacion==''||$model->telefono_contacto==''||$model->numero_personalidadJuridica==''||$model->numeroRut_representanteLegal==''||$model->fecha_personalidadJuridica==''||$model->domiciolio_representanteLegal==''||$model->organismoQueOtorgo_personalidadJuridica==''||$model->objetivos_generalesOrganizacion==''||$model->financiamiento_organizacion=='')
            {//validando section 1
                
                echo '<div style="color:#a94442;"><h4>Antecedentes Generales de la organización:</h4></div>';


                 if($model->nombre_organizacion=='') echo '<div style="color:#a94442;">Nombre de la organización.</div>';
                 if($model->nombre_representanteLegal=='') echo '<div style="color:#a94442;">Nombre del representante legal.</div>';
                 if($model->rut_organizacion=='') echo '<div style="color:#a94442;">Rut de la organización.</div>';
                 if($model->telefono_contacto=='') echo '<div style="color:#a94442;">Teléfono de contacto.</div>';
                 if($model->numero_personalidadJuridica=='') echo '<div style="color:#a94442;">Número de la personalidad jurídica.</div>';
                 if($model->numeroRut_representanteLegal=='') echo '<div style="color:#a94442;">Rut del representante legal.</div>';
                 if($model->fecha_personalidadJuridica=='') echo '<div style="color:#a94442;">Fecha de la personalidad jurídica.</div>';

                 if($model->domiciolio_representanteLegal=='') echo '<div style="color:#a94442;">Domicilio del representante legal.</div>';
                 if($model->organismoQueOtorgo_personalidadJuridica=='') echo '<div style="color:#a94442;">Organismo que otorgó la personalidad jurídica.</div>';

                 if($model->objetivos_generalesOrganizacion=='') echo '<div style="color:#a94442;">Objetivos generales de la organización.</div>';
                 if($model->financiamiento_organizacion=='') echo '<div style="color:#a94442;">Financiamiento de la organización.</div>';


            }


            if($model->area_subvencion==''||($model->area_subvencion=='Otra'&&$model->otra_subvencion==''))
            {//validando section 2
                echo '<div style="color:#a94442;"><h4>Subvención:</h4></div>';

                 if($model->area_subvencion=='') echo '<div style="color:#a94442;">Área a la que destinará la subvención.</div>';
                 if($model->area_subvencion=='Otra'&&$model->otra_subvencion=='') echo '<div style="color:#a94442;">Descripción del área a la que destinará la subvención.</div>';

            }

            if($model->nombre_proyecto==''||$model->numero_beneficiariosDirectos==''||$model->numero_unidadVecinal==''||$model->numero_beneficiariosIndirectos==''||$model->direccion_proyecto==''||$model->descripcion_beneficiariosDirectos==''||$model->objetivos_proyecto==''||$model->descripcion_proyecto=='')
            {//validando section 3
                echo '<div style="color:#a94442;"><h4>Características del proyecto:</h4></div>';
                 if($model->nombre_proyecto=='') echo '<div style="color:#a94442;">Nombre del proyecto.</div>';
                 if($model->numero_beneficiariosDirectos=='') echo '<div style="color:#a94442;">Números de beneficiarios directos.</div>';
                 if($model->numero_unidadVecinal=='') echo '<div style="color:#a94442;">Número de la unidad vecinal.</div>';
                 if($model->numero_beneficiariosIndirectos=='') echo '<div style="color:#a94442;">Números de beneficiarios indirectos.</div>';
                 if($model->direccion_proyecto=='') echo '<div style="color:#a94442;">Dirección del proyecto.</div>';
                 if($model->descripcion_beneficiariosDirectos=='') echo '<div style="color:#a94442;">Descripción de los beneficiarios directos.</div>';
                 if($model->objetivos_proyecto=='') echo '<div style="color:#a94442;">Objetivos del proyecto.</div>';
                 if($model->descripcion_proyecto=='') echo '<div style="color:#a94442;">Descripción del proyecto.</div>';

           
            }

        ?>
        </div>

        <div class="col-lg-5">

        <?php
            if($tablapresupuesto==null)
            {//validando section 4
                echo '<div style="color:#a94442;"><h4>Presupuesto del proyecto:</h4></div>';
                echo '<div style="color:#a94442;">Debe agregar el presupuesto de su proyecto.</div>';

            }



            if($tablaitemfinanciamiento==null||$model->financiamiento_aporte_propio==''||$model->financiamiento_aporte_solicitado==''||$model->financiamiento_aporte_terceros==''||$model->financiamiento_aporteTotal_proyecto=='')
            {//validando section 5
            
            echo '<div style="color:#a94442;"><h4>Financiamiento de la subvención municipal:</h4></div>';


                if($tablaitemfinanciamiento==null) echo '<div style="color:#a94442;">Detallar qué financiará con la subvención municipal.</div>';
                if($model->financiamiento_aporte_propio=='') echo '<div style="color:#a94442;">Aporte propio.</div>';
                if($model->financiamiento_aporte_solicitado=='') echo '<div style="color:#a94442;">Aporte solicitado.</div>';
                if($model->financiamiento_aporte_terceros=='') echo '<div style="color:#a94442;">Aporte de terceros.</div>';
                if($model->financiamiento_aporteTotal_proyecto=='') echo '<div style="color:#a94442;">Aporte total del proyecto.</div>';

            }


            if($tablacartagantt==null)
            {//validando section 6
                echo '<div style="color:#a94442;"><h4>Carta GANTT:</h4></div>';
                echo '<div style="color:#a94442;">Describa las actividades que realizará la organización mensualmente.</div>';


            }

            if($adjuntotipoarchivouno==null||$adjuntotipoarchivodos==null||$adjuntotipoarchivotres==null||$adjuntotipoarchivocuatro==null||$adjuntotipoarchivocinco==null||$adjuntotipoarchivoseis==null||$adjuntotipoarchivosiete==null||$adjuntotipoarchivoocho==null || $adjuntotipoarchivodiez==null)
            {//validando section 7
                 echo '<div style="color:#a94442;"><h4>Documentos solicitados:</h4></div>';
                 if($adjuntotipoarchivouno==null) echo '<div style="color:#a94442;">Carta de presentación y solicitud de financiamiento dirigida al Sr. Alcalde.</div>';
                 if($adjuntotipoarchivodos==null) echo '<div style="color:#a94442;">Carta de compromiso del representante legal que señala los aportes del proyecto.</div>';
                 if($adjuntotipoarchivotres==null) echo '<div style="color:#a94442;">Certificado de personalidad jurídica vigente.</div>';
                 if($adjuntotipoarchivocuatro==null) echo '<div style="color:#a94442;">Ficha de inscripción como organización receptora de fondos públicos.</div>';
                 if($adjuntotipoarchivocinco==null) echo  '<div style="color:#a94442;">Fotocopia de estatutos.</div>';
                 if($adjuntotipoarchivoseis==null) echo  '<div style="color:#a94442;">Carta de compromiso de los aportes de terceros al proyecto, si procede.</div>';
                 if($adjuntotipoarchivosiete==null) echo  '<div style="color:#a94442;">Certificado que acredite el lugar de funcionamiento de la organización, emitido por la institución o particular que lo facilita.</div>';
                 if($adjuntotipoarchivoocho==null) echo  '<div style="color:#a94442;">Certificado de compromiso de rendir cuenta documentada de los montos otorgados.</div>';
                  if($adjuntotipoarchivodiez==null) echo  '<div style="color:#a94442;">Cotizaciones del proyecto a desarrollar.</div>';

            }


        ?>
        </div>

<?php

    }else{

        if($totalPresupuestoProyecto == $model->financiamiento_aporteTotal_proyecto){

?>
<?= Html::a('<i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i>',
            ['/site/descargarborrador',
            'id_postulacion' => $model->id_postulacion
            ],
            ['class'=> 'btn btn-danger','style'=>'float:right; margin-right:5%;', 'title' => Yii::t('yii', 'Descargar borrador del formulario'), 'aria-label' => Yii::t('yii', 'Descargar borrador del formulario'), 'data-pjax' => '0',

            ] 

        );?>
        <?php
        echo '<div style="color:#3c763d"><h4>&nbsp;&nbsp;&nbsp;Para hacer efectiva su postulación debe dar click en el botón "Enviar Postulación".</h4></div>';
?>



<br>
<br>
<center>
<?= Html::a('Enviar postulación',
            ['/site/guardarpostulacion',
            'id_postulacion' => $model->id_postulacion
            ],
            ['class'=> 'btn btn-primary', 'title' => Yii::t('yii', 'Enviar postulación'), 'aria-label' => Yii::t('yii', 'Enviar postulación'), 'data-pjax' => '0',

            ] 

        );?>
</center>
<?php

    }else{
        echo '<div class="col-lg-8">';
        echo '<div style="color:#a94442;"><h4>Presupuesto del proyecto y financiamiento de la subvención municipal:</h4></div>';
        echo '<div style="color:#a94442;">El total de presupuesto del proyecto debe ser igual al aporte total del financiamiento.</div>';
        echo '</div>';
    }
}

?>
</div>


 <?= Html::a('Volver',

            ['/site/section7',
            'id_postulacion' => $model->id_postulacion
            ],
            ['class'=> 'btn btn-default', 'style'=>'float:right; margin-right:5%;', 'title' => Yii::t('yii', 'Volver'), 'aria-label' => Yii::t('yii', 'Volver'), 'data-pjax' => '0',

            ] 

);?>
    <br>
    <br>
