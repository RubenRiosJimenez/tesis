<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Fondo */


$this->title = Yii::t('app', 'Crear Fondo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fondos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fondo-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
