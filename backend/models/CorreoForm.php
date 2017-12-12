<?php

namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class CorreoForm extends Model
{
    public $subject;
    public $body;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['subject', 'body'], 'required'],
            // email has to be a valid email address
            // verifyCode needs to be entered correctly
        
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           // 'name'=> 'Nombre:',
            //'email'=>'Correo electrónico:',
            'subject'=>'Asunto:',
            'body'=>'Contenido:',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
}
