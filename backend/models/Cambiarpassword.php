<?php
namespace backend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class Cambiarpassword extends Model
{
    public $password_actual;
    public $password;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password_actual', 'required'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 20],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Las contraseñas no coinciden."],
        ];
    }

        public function attributeLabels()
    {
        return [
            'password_actual' => 'Contraseña actual:',
            'password' => 'Contraseña:',
            'password_repeat' => 'Repetir contraseña:',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function changepass($id)
    {
        if ($this->validate()) {
            $user = User::find()->where(['id' => $id])->one();
            if($user->validatePassword($this->password_actual)){
                $user->setPassword($this->password);
                    if ($user->save()) {
                        return $user;
                    }
            }else{
                return $this->addError('password_actual', 'La contraseña ingresada es incorrecta.');
            }
        }

        return null;
    }
}