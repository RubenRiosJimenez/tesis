<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$request = Yii::$app->request;
$id_formulario = $request->get('id_formulario');
$id_postulacion = $request->get('id_postulacion');

/* @var $this yii\web\View */
/* @var $model frontend\models\Tablapresupuesto */
/* @var $form yii\widgets\ActiveForm */
?>
 


<div class="tablapresupuesto-form">

    <?php $form =  ActiveForm::begin(['id' => 'tablapresupuesto-form', 'options' => ['data-pjax' => true]]); ?>
    <div class="row">

        <div class="col-lg-10">
            <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3">
        <?= $form->field($model, 'cantidad')->textInput(['maxlength'=>9]) ?>

        </div>
         <div class="col-lg-3">
            <?= $form->field($model, 'precioUnitario')->textInput(['maxlength'=>9]) ?>

            <?= $form->field($model, 'id_formulario')->hiddenInput(['value'=> $id_formulario])->label(false);?>
            </div>
        </div>
    <br>

    <div class="form-group">
       <?= Html::submitButton($model->isNewRecord ? 'Agregar' : 'Modificar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

 
