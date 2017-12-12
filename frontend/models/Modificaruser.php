<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class Modificaruser extends Model
{
    public $email;
    public $password;
    public $password_repeat;
    public $phone;
    public $currentPassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['currentPassword','required'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],

            ['phone', 'required'],
            ['phone', 'number'],

            ['password', 'string', 'min' => 6, 'max' => 20],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Las contraseñas no coinciden."],
        ];
    }

        public function attributeLabels()
    {
        return [
            'email' => 'Correo electrónico:',
            'phone' => 'Teléfono:',
            'currentPassword' => 'Contraseña actual:',
            'password' => 'Contraseña:',
            'password_repeat' => 'Repetir contraseña:',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function updateuser($id)
    {
        if ($this->validate()) {
            $user = User::find()->where(['id' => $id])->one();

            if($user->validatePassword($this->currentPassword)){

            $user->phone = $this->phone;

            $usuariosSistema2 = User::find()->where(['and',['email' => $this->email],['<>','id',$id]])->count();

            if($usuariosSistema2 > 0){
                return $this->addError('email', 'El correo ingresado ya existe.');
            }else{
                $user->email = $this->email;
            }            

            if($this->password != null){
                    $user->setPassword($this->password);
                    if ($user->save()) {
                        return $user;
                    }
            }else{
                    if ($user->save()) {
                        return $user;
                    }
            }

        }else{
            return $this->addError('currentPassword', 'La contraseña ingresada es incorrecta.');
        }
    }

        return null;
    }
}