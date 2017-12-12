<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
Hola <?= $user->username ?>,

Tu nombre de usuario es: <?= $user->username ?>

Si olvidaste tu contraseña haz click en el siguiente enlace:

<?= $resetLink ?>

Este es un correo automático generado por el Sistema de Postulación a Subvenciones Municipales de la Ilustre Municipalidad de Yungay, por favor no responder.
Para consultas llamar a Mesa Central al Fono: 42 - 2 205 600.

Saludos cordiales,
Ilustre Municipalidad de Yungay.
