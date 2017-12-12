<?php
namespace backend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class Modificaruser extends Model
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
            ['username', 'string', 'min' => 4, 'max' => 20],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],

            ['name', 'required'],
            ['name', 'string', 'max' => 80],

            ['phone', 'required'],
            ['phone', 'number'],

            ['role', 'required'],
            ['role', 'integer'],

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
    public function updateuser($id)
    {
        if ($this->validate()) {
            $user = User::find()->where(['id' => $id])->one();
            $user->name = $this->name;
            $user->role = $this->role;
            $user->phone = $this->phone;

            $usuariosSistema = User::find()->where(['and',['username' => $this->username],['<>','id',$id]])->count();
            $usuariosSistema2 = User::find()->where(['and',['email' => $this->email],['<>','id',$id]])->count();
            

            if($usuariosSistema > 0){
                return $this->addError('username', 'El usuario ingresado ya existe.');
            }else{
                $user->username = $this->username;
            }

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
        }

        return null;
    }
}