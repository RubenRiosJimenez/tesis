<?php

use yii\helpers\Html;
use backend\models\Formulario;
use backend\models\Resultado;
use backend\models\Evaluacion;
use backend\models\Concursante;//no es igual al de backend
use backend\models\Postulacion;//no es igual al de backend
use backend\models\Convocatoria;
use backend\models\EvaluacionArchivo;
use backend\models\EstadoevaluacionArchivo;
use backend\models\Tipoarchivo;
use common\models\User;
use kartik\detail\DetailView;
use himiklab\ckeditor\CKEditor;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Postulacion */

$this->title = 'Detalle de la postulación:';

?>

<?php

$request = Yii::$app->request;
$id_convocatoria = $request->get('id_convocatoria');
$id_postulacion = $request->get('id_postulacion');
$buscaConvocatoria = Convocatoria::find()->where(['id_convocatoria' => $id_convocatoria])->one();
$buscaPostulacion = Postulacion::find()->where(['id_convocatoria' => $id_convocatoria])->one(); 
$id_concursante=$buscaPostulacion->id_concursante;
$buscaFormulario = Formulario::find()->where(['id_postulacion' => $id_postulacion])->one(); 
$buscaEvaluacion = Evaluacion::find()->where(['id_postulacion' => $id_postulacion])->one();
$buscaEvaluacionArchivo = EvaluacionArchivo::find()->where(['id_evaluacion' => $buscaEvaluacion->id_evaluacion])->all();
$buscaConcursante= Concursante::find()->where(['id_concursante'=>$id_concursante])->one();
$buscaUser = User::find()->where(['id' => $buscaConcursante->id])->one();
     

?>
<div class="postulacion-view" style = "max-width: 1200px; word-wrap: break-word;">

    <h4>Resultados de la Convocatoria: <strong><?= Html::encode($buscaConvocatoria->nombreConvocatoria) ?></strong> </h4>
</div>
<br>
<div class="row">
    <div class="col-lg-4">
<?php
echo DetailView::widget([
    'model'=>$model,
    'condensed'=>true,
    //'alertContainerOptions' => ['class'=>'hide']
    'alertContainerOptions' => ['style'=>'display:none'],
    'responsive' => true,
    'bordered' => true,
    'bootstrap' => true,
    'striped' => true,
    'hover'=>true,
    'enableEditMode' => false,
    'hAlign'=>DetailView::ALIGN_LEFT,
    'vAlign' => DetailView::ALIGN_MIDDLE,
    'mode'=>DetailView::MODE_VIEW,
    'panel'=>[
        'heading'=>'Información del concursante:',
        'type'=>DetailView::TYPE_SUCCESS,
    ],
    'labelColOptions' => [
    'style' => 'width: 20%',
    ],
    'valueColOptions' => [
        'style' => 'max-width: 200px; word-wrap: break-word;',
    ],
    'attributes'=>[


        [
            'label'  => 'Nombre:',
            'value'  => $buscaConcursante->nombreConcursante,
        ],

        [
            'label'  => 'RUT:',
            'value'  => $buscaConcursante->rut,
        ],

        [
            'label'  => 'Teléfono:',
            'value'  => $buscaConcursante->telefono,
        ],

        [
            'label'  => 'Correo:',
            'value'  => $buscaUser->email,
        ],

        [
            'label'  => 'Nombre del proyecto:',
            'value'  => $buscaFormulario->nombre_proyecto,
        ], 

        [
            'label'  => 'Aporte propio:',
            'value'  => '$ '.number_format($buscaFormulario->financiamiento_aporte_propio, 0, ",", "."),
        ], 

        [
            'label'  => 'Aporte de terceros:',
            'value'  => '$ '.number_format($buscaFormulario->financiamiento_aporte_terceros, 0, ",", "."),
        ], 

        [
            'label'  => 'Aporte solicitado:',
            'value'  => '$ '.number_format($buscaFormulario->financiamiento_aporte_solicitado, 0, ",", "."),
        ],                 

        [
            'label'  => 'Aporte total del proyecto:',
            'value'  => '$ '.number_format($buscaFormulario->financiamiento_aporteTotal_proyecto, 0, ",", "."),
        ],
        [
            'label'  => 'Beneficiarios directos:',
            'value'  => $buscaFormulario->numero_beneficiariosDirectos.' personas.',
        ],                 


        ],
        ]) ?>

    </div>

    <div class="col-lg-8">
<?php
echo DetailView::widget([
    'model'=>$model,
    'condensed'=>true,
    'responsive' => true,
    //'alertContainerOptions' => ['class'=>'hide']
    'alertContainerOptions' => ['style'=>'display:none'],
    'bordered' => true,
    'bootstrap' => true,
    'striped' => true,
    'hover'=>true,
    'enableEditMode' => false,
    'hAlign'=>DetailView::ALIGN_LEFT,
    'vAlign' => DetailView::ALIGN_MIDDLE,
    'mode'=>DetailView::MODE_VIEW,
    'panel'=>[
        'heading'=>'Resultado de la postulación',
        'type'=>DetailView::TYPE_DANGER,
    ],
    'labelColOptions' => [
    'style' => 'width: 30%',
    ],
    'valueColOptions' => [
        'style' => 'max-width: 300px; word-wrap: break-word;',
    ],
    'attributes'=>[
[
            'label'  => 'Estado:',
            'format' => 'html',
            'value'  => 'Sin asignación de beneficio.',
        ],   


        [
            'label'  => 'Observaciones:',
            'format' => 'html',
            'value'  => $buscaEvaluacion->observaciones_1,
        ],   

        ],
        ]) ?>

        </div>
</div>
<br>

<?php
$contador = 0;
foreach($buscaEvaluacionArchivo as $evaluacionArchivo){

    if((ctype_space($evaluacionArchivo->observaciones) == false) && ($evaluacionArchivo->observaciones != null)){
        $contador += 1;

    }

}

if($contador > 0){

?>

  <div id="abrir">
            <button onclick="hideoff()" type="button" class="btn btn-info">Mostrar detalle de la revisión de los documentos</button>
        </div>
        <div id="cerrar" style="display: none;">
            <button onclick="hideon()" type="button" class="btn btn-primary">Ocultar detalle de la revisión de los documentos</button>
        </div>
    <br>
    <div style="display: none;" id="detalle" class="row">
        <div class="col-lg-8">
        <h4>Detalle de la revisión de documentos:</h4>
        <br>
<?php

foreach($buscaEvaluacionArchivo as $evaluacionArchivo){

        if((ctype_space($evaluacionArchivo->observaciones) == false) && ($evaluacionArchivo->observaciones != null)){
        
        $buscaTipoArchivo = Tipoarchivo::find()->where(['id_tipoArchivo' => $evaluacionArchivo->id_tipoArchivo])->one();


    echo DetailView::widget([
    'model'=>$model,
    'condensed'=>true,
    'responsive' => true,
    'alertContainerOptions' => ['style'=>'display:none'],
    'bordered' => true,
    'bootstrap' => true,
    'striped' => true,
    'hover'=>true,
    'enableEditMode' => false,
    'hAlign'=>DetailView::ALIGN_LEFT,
    'vAlign' => DetailView::ALIGN_MIDDLE,
    'mode'=>DetailView::MODE_VIEW,
    'panel'=>[
        'type'=>DetailView::TYPE_INFO,
    ],
    'labelColOptions' => [
    'style' => 'width: 20%',
    ],
    'valueColOptions' => [
        'style' => 'max-width: 300px; word-wrap: break-word;',
    ],
    'attributes'=>[

        [
            'label'  => 'Documento:',
            'format' => 'html',
            'value'  => $buscaTipoArchivo->nombre_tipoArchivo,
        ], 


        [
            'label'  => 'Observación:',
            'format' => 'html',
            'value'  => $evaluacionArchivo->observaciones,
        ],   

        ],
        ]);
}

}
?>

        </div>
    </div>
    <br>
<?php
}
?>

   <div class="form-group">

        <?= Html::a('Volver',

            ['/postulacion/index'],
            ['class'=> 'btn btn-default', 'style'=>'float:right', 'title' => Yii::t('yii', 'Volver'), 'aria-label' => Yii::t('yii', 'Volver'), 'data-pjax' => '0',

            ] 

        );?>
    </div>
<br>
<br>

<script>
        function hideoff() {
            $('#detalle').show();
            $('#cerrar').show();
            $('#abrir').hide();
        }

        function hideon() {
            $('#detalle').hide();
            $('#cerrar').hide();
            $('#abrir').show();
        }
</script>