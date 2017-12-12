<?php

namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "concursante".
 *
 * @property integer $id_concursante
 * @property integer $id_tipoConcursante
 * @property integer $id
 * @property string $nombreConcursante
 * @property string $rut
 * @property string $domicilio
 * @property string $telefono
 *
 * @property Tipoconcursante $idTipoConcursante
 * @property User $id0
 * @property Postulacion[] $postulacions
 */
class Concursante extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'concursante';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
         ['rut', 'validateRut'],
         ['telefono','validateLargoTelefono'],
            [['nombreConcursante','rut','domicilio','telefono','id_tipoConcursante'],'required'],
            [['id_tipoConcursante', 'id'], 'integer'],
            [['nombreConcursante'], 'string', 'max' => 80],
            [['rut'], 'string', 'max' => 50],
            [['domicilio'], 'string', 'max' => 80],
            [['telefono'], 'number'],
            [['id_tipoConcursante'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoconcursante::className(), 'targetAttribute' => ['id_tipoConcursante' => 'id_tipoConcursante']],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_concursante' => 'Id Concursante',
            'id_tipoConcursante' => 'Tipo de concursante:',
            'id' => 'ID',
            'nombreConcursante' => 'Nombre del concursante:',
            'rut' => 'Rut del concursante:',
            'domicilio' => 'Domicilio del concursante:',
            'telefono' => 'Teléfono del concursante:',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoConcursante()
    {
        return $this->hasOne(Tipoconcursante::className(), ['id_tipoConcursante' => 'id_tipoConcursante']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostulacions()
    {
        return $this->hasMany(Postulacion::className(), ['id_concursante' => 'id_concursante']);
    }

    /*public function validateRut($attribute, $params) {
    $r = $this->rut;
    $r=strtoupper(ereg_replace('\.|,|-','',$r));
    $sub_rut=substr($r,0,strlen($r)-1);
    $sub_dv=substr($r,-1);
    $x=2;
    $s=0;
    for ( $i=strlen($sub_rut)-1;$i>=0;$i-- )
    {
        if ( $x >7 )
        {
            $x=2;
        }
        $s += $sub_rut[$i]*$x;
        $x++;
    }
    $dv=11-($s%11);
    if ( $dv==10 )
    {
        $dv='K';
    }
    if ( $dv==11 )
    {
        $dv='0';
    }
    if ( $dv!=$sub_dv )
    {
        $this->addError('rut', 'Rut inválido.');
    }
}*/

public function validateRut($attribute, $params) {
    $rut=$this->rut;
    $rut = preg_replace('/[\.]/i', '', $rut);
    if ( !preg_match("/^[0-9]+-[0-9kK]{1}/",$rut)) {
        $this->addError('rut', 'Rut inválido.');
    }
    $rut = preg_replace('/[\-]/i', '', $rut);
    $dv = substr($rut, -1);
    $numero = substr($rut, 0, strlen($rut) - 1);
    $i = 2;
    $suma = 0;
    foreach (array_reverse(str_split($numero)) as $v) {
        if ($i == 8)
            $i = 2;
        $suma += $v * $i;
        ++$i;
    }
    $dvr = 11 - ($suma % 11);
    if ($dvr == 11)
        $dvr = 0;
    if ($dvr == 10)
        $dvr = 'K';
    if ($dvr != strtoupper($dv))
        $this->addError('rut', 'Rut inválido.');
}


public function validateLargoTelefono($attribute, $params) 
{
    $telefono= $this->telefono;
    $largo=strlen($telefono);
    if($largo!=9){
         $this->addError('telefono', 'El teléfono debe tener nueve dígitos.');
    }



}

}
