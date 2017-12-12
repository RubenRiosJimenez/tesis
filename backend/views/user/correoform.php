<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use himiklab\ckeditor\CKEditor;

use backend\models\User;

$request = Yii::$app->request;
$id_usuario = $request->get('id');
$usuario =  User::find()->where(['id' => $id_usuario])->one();

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = 'Envío de correo personalizado a '.$usuario->name.'';
?>
<div class="site-contact">
  
    <p>
        Para enviar un correo debe completar los siguientes campos: 
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                <?= $form->field($model, 'subject') ?>
                <?= $form->field($model, 'body')->textArea(['rows' => 9]) ?>
                   <div class="form-group">
                    <?= Html::submitButton('Enviar correo', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                        <?= Html::a('Volver',

            ['index'],
            ['class'=> 'btn btn-default', 'style' => 'margin-left: 2%', 'title' => Yii::t('yii', 'Volver'), 'aria-label' => Yii::t('yii', 'Volver'), 'data-pjax' => '0',

            ] 

        );?>

                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
