<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Adjunto;
use backend\models\Tipoarchivo;
use backend\models\Formulario;
use backend\models\Evaluacion;
use backend\models\EvaluacionArchivo;
use backend\models\Estadoevaluacionarchivo;
use backend\models\Postulacion;
use backend\models\Concursante;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use himiklab\ckeditor\CKEditor;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
$this->title = 'Revisión de documentos y Grado de Colaboración con la Función Municipal:';
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
            <strong>Documentos del concursante <?= Html::encode($buscaConcursante->nombreConcursante) ?></strong>
                        <br>
            <br>
            Si la convocatoria no solicita <strong>Otros documentos</strong>, se le debe evaluar como <strong>Cumple requisitos</strong>.
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
                //'attribute' => 'fecha_inicio',
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

            [
                'label'=>'Estado del documento',
                'format' => 'html',
                'headerOptions' => ['class' => 'text-center'],
            'contentOptions' =>function ($model, $key, $index, $column){
                    return ['class' => 'tbl_column_name text-center'];
            },

            'value'=>function ($data) {
                $id_postulacion=Yii::$app->request->get('id_postulacion');
                $buscaEvaluacion = Evaluacion::find()->where(['id_postulacion' => $id_postulacion])->one();
                $buscaEvaluacionArchivo = EvaluacionArchivo::find()->where(['and',['id_evaluacion' => $buscaEvaluacion->id_evaluacion],['id_tipoArchivo' => $data->id_tipoArchivo]])->one();
                        if($buscaEvaluacionArchivo == null){
                            return Html::tag('span','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pendiente de revisión&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', ['class' => 'label label-warning', 'style'=>'font-size: 12px;']);                  
                        }else{
                                $buscaEstadoEvaluacion = Estadoevaluacionarchivo::find()->where(['id_estado' => $buscaEvaluacionArchivo->id_estado])->one();                   
                                if($buscaEvaluacionArchivo->id_estado == 1){
                                    return Html::tag('span','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$buscaEstadoEvaluacion->descripcion_estado.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', ['class' => 'label label-warning', 'style'=>'font-size: 12px;']);
                                }else{
                                    if($buscaEvaluacionArchivo->id_estado == 2){
                                        return Html::tag('span', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$buscaEstadoEvaluacion->descripcion_estado.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', ['class' => 'label label-danger', 'style'=>' font-size: 12px;']);
                                    }else{
                                        if($buscaEvaluacionArchivo->id_estado == 3){
                                            return Html::tag('span', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$buscaEstadoEvaluacion->descripcion_estado.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', ['class' => 'label label-primary', 'style'=>' font-size: 12px;']);
                                        }else{
                                            if($buscaEvaluacionArchivo->id_estado == 4){
                                                return Html::tag('span',$buscaEstadoEvaluacion->descripcion_estado, ['class' => 'label label-info', 'style'=>' font-size: 12px;']);
                                            }
                                        }
                                    }
                                }
                            }
            },
            ],            

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{buscar}',
            'buttons' => ['buscar'=>function($url,$model,$key){
                return Html::button('<span class="glyphicon glyphicon-search"></span>', ['value'=>Url::to(['/adjunto/index','id_tipoArchivo' => $model->id_tipoArchivo, 'id_postulacion'=>Yii::$app->request->get('id_postulacion')]), 'class' => 'btn btn-success modalButton-3', 'title' => Yii::t('yii', 'Revisar documentos'), 'aria-label' => Yii::t('yii', 'Revisar documentos'), ]);
            },
            

            ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>


<br>
        <div id="abrir">
            <button onclick="hideoff()" type="button" class="btn btn-info">Mostrar detalle de la evaluación</button>
        </div>
        <div id="cerrar" style="display: none;">
            <button onclick="hideon()" type="button" class="btn btn-primary">Ocultar detalle de la evaluación</button>
        </div>
    <br>
    <div style="display: none;" id="detalle" class="row">
        <div class="col-lg-12">
            <strong>Revisión de documentos y Grado de Colaboración con la Función Municipal:</strong>
            <br>
            <br>
            Se refiere a que el proyecto o programa presentado no tenga fines de lucro y su objetivo esté relacionado y colabore con la función del Municipio:
            <br>
            <br>
            <strong>Categorías:</strong>
            <br>
            <br>
            <strong>Alta:</strong> Se refiere a que el proyecto o programa presentado está directamente relacionado con las funciones del Municipio y colabora con él. Se le asignarán <strong>3 puntos</strong>.
            <br>
            <strong>Media:</strong> Se refiere a que el proyecto o programa presentado está indirectamente relacionado o en alguno de sus objetivos con la función del Municipio. Se le asignarán <strong>2 puntos</strong>.
            <br>
            <strong>Baja:</strong> Se refiere a que el proyecto o programa no tiene relación con las funciones del Municipio y le corresponderá <strong>cero puntos</strong>.

        </div>
    </div>
    <br>

<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-3">

            <?= $form->field($model, 'id_estado')->dropDownList($items,['style' => 'width:90%;', 'onchange' => 'show_value(this.value)']) ?>
            <br>
            <?= 
                $form->field($model, 'observaciones_1')->widget(CKEditor::className(), ['editorOptions' => ['height' => '250px', 'width'=>'600px','toolbarSet'=>'Basic',]]);   
            ?>
                               
        </div>


        <?php
        if($model->id_estado== 3){
            echo '<div id ="hide" class="col-lg-3">';
        }else{
            echo '<div id ="hide" class="col-lg-3" style="display: none;">';
        }
       

             echo $form->field($model, 'puntaje_1')->dropDownList(['3' => 'Alta: 3 puntos', '2' => 'Media: 2 puntos', '0' => 'Baja: 0 puntos'],['id' => 'puntaje', 'style' => 'width:90%;', 'prompt'=>'Seleccione:']); ?>

    </div>
    </div>        

    </div>    

   <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary'])
         ?>

        <?= Html::a('Volver',

            ['/postulacion/evaluacion1'],
            ['class'=> 'btn btn-default', 'style'=>'float:right', 'title' => Yii::t('yii', 'Volver'), 'aria-label' => Yii::t('yii', 'Volver'), 'data-pjax' => '0',

            ] 

        );?>
    </div>


<?php ActiveForm::end(); ?>
    
</div>


    <?php
        Modal::begin([
                'header'=>'<h3>Revisión de documentos<h3>',
                'id' => 'modal-3',
                'size' => 'modal-lg',
            ]);
        echo "<div id='modalContent-3'></div>";

        Modal::end();
    ?>

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


<script type="text/javascript">
function show_value(val) {
    if(val == 3){
        $('#hide').show();
    }else{
        $('#hide').hide();
        document.getElementById('puntaje').value = "";
    }
}
</script>