<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Hola <?= Html::encode($user->username) ?>,</p>

    <p>Tu nombre de usuario es: <strong><?= Html::encode($user->username) ?></p></strong>

    <p>Si olvidaste tu contraseña haz click en el siguiente enlace:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>

    <p>Este es un correo automático generado por el Sistema de Postulación a Subvenciones Municipales de la Ilustre Municipalidad de Yungay, por favor no responder.</p>
    <p>Para consultas llamar a Mesa Central al Fono: 42 - 2 205 600.</p>
    <br>
    <p>Saludos cordiales,</p>
    <p>Ilustre Municipalidad de Yungay.</p>
</div>
