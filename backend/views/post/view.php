<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\post */

$this->title = $model->titulo_post;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publicaciones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">



    <p>
        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->id_post], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Volver'), ['index', 'id' => $model->id_post], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $model->id_post], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Está seguro que desea eliminar ésta publicación?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'titulo_post',
            'cuerpo_post:html',
            'fecha_creacion_post',
            [
                'attribute'=>'imagen_Post',
                'value'=> Yii::getAlias('@noticiaImgUrl').'/'. $model->imagen_Post,
                'format'=>['image', ['width'=> '100', 'height'=> '100']]
            ]
        ],
    ]) ?>

</div>
