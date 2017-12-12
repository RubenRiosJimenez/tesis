<?php

namespace backend\models;
use yii\db\ActiveRecord;

use Yii;

/**
 * ContactForm is the model behind the contact form.
 */
class FormularioActiveRecord extends ActiveRecord
{
     public static function tableName()
    {
        return 'formulario';
    }


      
}
