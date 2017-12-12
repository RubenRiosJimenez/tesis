<?php

use yii\helpers\Html;
use common\models\User;
use kartik\detail\DetailView;
use himiklab\ckeditor\CKEditor;
use yii\widgets\ActiveForm;
use backend\models\Tipoconcursante;

/* @var $this yii\web\View */
/* @var $model backend\models\Postulacion */

$this->title = 'Detalle del concursante:';

$buscaTipoConcursante = Tipoconcursante::find()->where(['id_tipoConcursante' => $model->id_tipoConcursante])->one();
$buscaUser = User::find()->where(['id' => $model->id])->one();
?>

<br>

<div class="row">
    <div class="col-lg-8">
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
    'style' => 'width: 30%',
    ],
    'valueColOptions' => [
        'style' => 'max-width: 200px; word-wrap: break-word;',
    ],
    'attributes'=>[


        [
            'label'  => 'Nombre:',
            'value'  => $model->nombreConcursante,
        ],

        [
            'label'  => 'RUT:',
            'value'  => $model->rut,
        ],
        [
            'label'  => 'Dirección:',
            'value'  => $model->domicilio,
        ],
        [
            'label'  => 'Teléfono:',
            'value'  => $model->telefono,
        ],

        [
            'label'  => 'Correo:',
            'value'  => $buscaUser->email,
        ],

        [
            'label'  => 'Personalidad jurídica:',
            'value'  => $buscaTipoConcursante->nombreTipo,
        ], 

        ],
        ]) ?>

    </div>
</div>

   <div class="form-group">

        <?= Html::a('Volver',

            ['/user/index'],
            ['class'=> 'btn btn-default', 'style'=>'float:right', 'title' => Yii::t('yii', 'Volver'), 'aria-label' => Yii::t('yii', 'Volver'), 'data-pjax' => '0',

            ] 

        );?>
    </div>
<br>
<br>