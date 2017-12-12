<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use himiklab\ckeditor\CKEditor;
$request = Yii::$app->request;
$id_formulario = $request->get('id_formulario');
$id_postulacion = $request->get('id_postulacion');
/* @var $this yii\web\View */
/* @var $model frontend\models\Tablacartagantt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tablacartagantt-form">

    <?php $form =  ActiveForm::begin(['id' => 'tablacartagantt-form', 'options' => ['data-pjax' => true]]); ?>

    <div class="row">
        <div class="col-lg-3">
    		<?php echo $form->field($model, 'mes')->dropDownList(['Enero' => 'Enero', 'Febrero' => 'Febrero', 'Marzo' => 'Marzo', 'Abril' => 'Abril', 'Mayo' => 'Mayo', 'Junio' => 'Junio', 'Julio' => 'Julio', 'Agosto' => 'Agosto', 'Septiembre' => 'Septiembre', 'Octubre' => 'Octubre', 'Noviembre' => 'Noviembre', 'Diciembre' => 'Diciembre'],['prompt'=>'Seleccione:']); ?>
    	</div>
    </div>

                <?= $form->field($model, 'descripcion')->textArea(['style' => 'width: 600px', 'rows' => '10']) ?> 
                <?= $form->field($model, 'id_formulario')->hiddenInput(['value'=> $id_formulario])->label(false);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Agregar' : 'Modificar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>