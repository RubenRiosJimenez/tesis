<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
?>
<div class="post">

    <div class="item  col-xs-4 col-lg-4">
        <div class="thumbnail">
            <?= Html::img(Yii::getAlias('@noticiaImgUrl')."/".$model->imagen_Post,['class'=>'group list-group-image', 'style' => 'width: 350px; height: 190px']) ?>
            <!--img class="group list-group-image" src="http://placehold.it/400x250/000/fff" alt="" /-->
            <div class="caption">
                <h4 class="group inner list-group-item-heading">
                    <?= Html::encode($model->titulo_post) ?></h4>
                <div class="row">
                    <div class="col-lg-12 col-md-6">
                        <p class="lead">
                            <?= HtmlPurifier::process($model->getSubString($model->cuerpo_post, 20)) ?></p>

                    </div>
                    <div class="col-lg-12 col-md-6" style="text-align: right;">
                        <a class="btn btn-success" href="<?php echo Url::toRoute(['post/detalle', 'id' => $model->id_post]); ?>">Ver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>