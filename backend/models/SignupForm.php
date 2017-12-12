<?php
namespace backend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $name;
    public $role;
    public $password;
    public $password_repeat;
    public $phone;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'El usuario ingresado ya existe.'],
            ['username', 'string', 'min' => 4, 'max' => 20],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'El correo electrónico ingresado ya existe.'],

            ['name', 'required'],
            ['name', 'string', 'max' => 80],

            ['phone', 'required'],
            ['phone', 'number'],

            ['role', 'required'],
            ['role', 'integer'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 20],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Las contraseñas no coinciden."],
        ];
    }

        public function attributeLabels()
    {
        return [
            'username' => 'Usuario:',
            'email' => 'Correo electrónico:',
            'name' => 'Nombre completo:',
            'role' => 'Perfil:',
            'phone' => 'Teléfono:',
            'password' => 'Contraseña:',
            'password_repeat' => 'Repetir contraseña:',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->name = $this->name;
            $user->role = $this->role;
            $user->phone = $this->phone;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}