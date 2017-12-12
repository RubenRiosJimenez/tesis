<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\bases */

$this->title = Yii::t('app', 'Crear una Base');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bases-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
