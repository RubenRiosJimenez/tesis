<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\post */

$this->title = Yii::t('app', 'Actualizar {modelClass}: ', [
    'modelClass' => 'Publicación',
]) . $model->titulo_post;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publicaciones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_post, 'url' => ['view', 'id' => $model->id_post]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizar');
?>
<div class="post-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
