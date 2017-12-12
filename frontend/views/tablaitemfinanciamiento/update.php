<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Tablaitemfinanciamiento */

$this->title = 'Modificar financiamiento:';
?>
<div class="tablaitemfinanciamiento-update">

    <h3><?= Html::encode($this->title) ?></h3>
	<hr>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
