<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\bases */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bases-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_base')->textInput() ?>

    <?= $form->field($model, 'nombre_base')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_fondo')->textInput() ?>

    <?= $form->field($model, 'cuerpo_base')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
