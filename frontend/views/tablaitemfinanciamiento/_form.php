<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$request = Yii::$app->request;
$id_formulario = $request->get('id_formulario');
$id_postulacion = $request->get('id_postulacion');
/* @var $this yii\web\View */
/* @var $model frontend\models\Tablaitemfinanciamiento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tablaitemfinanciamiento-form">

    <?php $form =  ActiveForm::begin(['id' => 'tablaitemfinanciamiento-form', 'options' => ['data-pjax' => true]]); ?>
    <div class="row">

        <div class="col-lg-10">
    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
             <div class="col-lg-3">
                 <?= $form->field($model, 'monto')->textInput(['maxlength'=>9]) ?>
    </div>
    </div>
    <?= $form->field($model, 'id_formulario')->hiddenInput(['value'=> $id_formulario])->label(false);?>

    <br>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Agregar' : 'Modificar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>