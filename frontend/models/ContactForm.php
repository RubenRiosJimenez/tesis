<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Código de verificación:',
            'name'=> 'Nombre:',
            'email'=>'Correo electrónico:',
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
    public function sendEmail($email,$copia)
    {
        $content= "<p> Correo electrónico: ". $this->email."</p>";
        $content.= "<p> Nombre: ". $this->name."</p>";
        $content.= "<p> Asunto: ". $this->subject."</p>";
        $content.= "<p> Contenido: ". $this->body."</p>";
    
        return Yii::$app->mailer->compose("layouts\html",["content"=> $content])
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setCc($copia)
            ->setTextBody($this->body)
            ->send();
    }
}
