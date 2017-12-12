<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Tablapresupuesto */


$this->title = 'Agregar presupuesto:';
?>
<div class="tablapresupuesto-create">

    <h3><?= Html::encode($this->title) ?></h3>
    <hr>
    <?= 


    $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
