<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Datos Personales';

?>

<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <p><?php ?></p>


            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <div class="row">
               
                    <div class="col-lg-5">
                        <?= $form->field($concursante, 'domicilio') ?>
                        <?= $form->field($model, 'phone')->textInput(['style'=>'height:1%;','maxlength'=>9,'placeholder' => 'Ejemplo: Cel: 987432213 ó Fono: 422312456']); ?>
                        <?= $form->field($model, 'currentPassword')->passwordInput() ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>
                        <?= $form->field($model, 'password_repeat')->passwordInput() ?>

                          </div>
                    <div class="col-lg-5">
                          <?= $form->field($model, 'email') ?>
                          <?= $form->field($concursante, 'id_tipoConcursante')->dropDownList($items,['prompt'=>'Seleccione','style' => 'width:90%;']) ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::submitButton('Modificar', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
</div>

