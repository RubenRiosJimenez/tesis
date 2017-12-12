<?php

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "formulario".
 *
 * @property integer $id_formulario
 * @property integer $id_postulacion
 * @property integer $numero_formulario
 * @property string $fecha_presentacion
 * @property string $nombre_organizacion
 * @property string $rut_organizacion
 * @property string $nombre_representanteLegal
 * @property string $area_subvencion
 * @property string $otra_subvencion
 * @property string $telefono_contacto
 * @property string $numeroRut_representanteLegal
 * @property string $numero_personalidadJuridica
 * @property string $fecha_personalidadJuridica
 * @property string $organismoQueOtorgo_personalidadJuridica
 * @property string $objetivos_generalesOrganizacion
 * @property string $financiamiento_organizacion
 * @property string $domiciolio_representanteLegal
 * @property string $nombre_proyecto
 * @property string $numero_unidadVecinal
 * @property string $direccion_proyecto
 * @property string $objetivos_proyecto
 * @property string $descripcion_proyecto
 * @property string $numero_beneficiariosDirectos
 * @property string $numero_beneficiariosIndirectos
 * @property string $descripcion_beneficiariosDirectos
 * @property string $financiamiento_aporte_propio
 * @property string $financiamiento_aporte_terceros
 * @property string $financiamiento_aporte_solicitado
 * @property string $financiamiento_aporteTotal_proyecto
 *
 * @property Adjunto[] $adjuntos
 * @property Evaluacion[] $evaluacions
 * @property Postulacion $idPostulacion
 * @property Tablacartagantt[] $tablacartagantts
 * @property Tablaitemfinanciamiento[] $tablaitemfinanciamientos
 * @property Tablapresupuesto[] $tablapresupuestos
 */
class Formulario extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'formulario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		['financiamiento_aporte_propio','validarAportes'],
        ['financiamiento_aporte_terceros','validarAportes'],
        ['financiamiento_aporteTotal_proyecto','validarSuma'],
        ['rut_organizacion', 'validateRut'],
            [['id_postulacion', 'numero_beneficiariosDirectos', 'numero_beneficiariosIndirectos', 'financiamiento_aporte_propio', 'financiamiento_aporte_terceros', 'financiamiento_aporte_solicitado'], 'integer'],
            [['fecha_personalidadJuridica'], 'safe'],
            [['nombre_organizacion', 'area_subvencion'], 'string', 'max' => 300],
            [['rut_organizacion', 'numeroRut_representanteLegal', 'financiamiento_aporteTotal_proyecto'], 'string', 'max' => 50],
            [['nombre_representanteLegal', 'organismoQueOtorgo_personalidadJuridica', 'domiciolio_representanteLegal', 'nombre_proyecto', 'direccion_proyecto'], 'string', 'max' => 150],
            [['otra_subvencion', 'objetivos_generalesOrganizacion', 'financiamiento_organizacion', 'objetivos_proyecto', 'descripcion_proyecto', 'descripcion_beneficiariosDirectos'], 'string', 'max' => 500],
            [['numero_unidadVecinal'], 'string', 'max' => 20],
            [['telefono_contacto'], 'number'],
            [['numero_personalidadJuridica'], 'string', 'max' => 30],
            [['id_postulacion'], 'exist', 'skipOnError' => true, 'targetClass' => Postulacion::className(), 'targetAttribute' => ['id_postulacion' => 'id_postulacion']],
        ];

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_formulario' => 'Id Formulario',
            'id_postulacion' => 'Id Postulacion',
            'nombre_organizacion' => 'Nombre de la organización',
            'rut_organizacion' => 'Rut de la organización',
            'nombre_representanteLegal' => 'Nombre del representante legal',
            'area_subvencion' => 'Área de la subvención',
            'otra_subvencion' => 'Otra subvención',
            'telefono_contacto' => 'Teléfono de contacto',
            'numeroRut_representanteLegal' => 'Rut del representante legal',
            'numero_personalidadJuridica' => 'Número de la personalidad jurídica',
            'fecha_personalidadJuridica' => 'Fecha de la personalidad jurídica',
            'organismoQueOtorgo_personalidadJuridica' => 'Organismo que otorgó la personalidad jurídica',
            'objetivos_generalesOrganizacion' => 'Objetivos generales de la organización o institución',
            'financiamiento_organizacion' => 'Financiamiento de la organización',
            'domiciolio_representanteLegal' => 'Domicilio del representante legal',
            'nombre_proyecto' => 'Nombre del proyecto',
            'numero_unidadVecinal' => 'Número de la unidad vecinal',
            'direccion_proyecto' => 'Dirección del proyecto',
            'objetivos_proyecto' => 'Objetivos del proyecto',
            'descripcion_proyecto' => 'Descripción del proyecto',
            'numero_beneficiariosDirectos' => 'Números de beneficiarios directos',
            'numero_beneficiariosIndirectos' => 'Números de beneficiarios indirectos',
            'descripcion_beneficiariosDirectos' => 'Descripción de los beneficiarios directos del proyecto',
            'financiamiento_aporte_propio' => 'Aporte propio ($)',
            'financiamiento_aporte_terceros' => 'Aporte de terceros ($)',
            'financiamiento_aporte_solicitado' => 'Aporte solicitado ($)',
            'financiamiento_aporteTotal_proyecto' => 'Aporte total del proyecto ($)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdjuntos()
    {
        return $this->hasMany(Adjunto::className(), ['id_formulario' => 'id_formulario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluacions()
    {
        return $this->hasMany(Evaluacion::className(), ['id_formulario' => 'id_formulario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPostulacion()
    {
        return $this->hasOne(Postulacion::className(), ['id_postulacion' => 'id_postulacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTablacartagantts()
    {
        return $this->hasMany(Tablacartagantt::className(), ['id_formulario' => 'id_formulario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTablaitemfinanciamientos()
    {
        return $this->hasMany(Tablaitemfinanciamiento::className(), ['id_formulario' => 'id_formulario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTablapresupuestos()
    {
        return $this->hasMany(Tablapresupuesto::className(), ['id_formulario' => 'id_formulario']);
    }

    /**
     * @inheritdoc
     * @return FormularioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FormularioQuery(get_called_class());
    }




/*public function validateRut($attribute, $params) {
    $r = $this->rut_organizacion;
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
        $this->addError('rut_organizacion', 'Rut inválido.');
    }
}*/

public function validateRut($attribute, $params) {
    $rut=$this->rut_organizacion;
    if ( !preg_match("/^[0-9]+-[0-9kK]{1}/",$rut)) {
        $this->addError('rut_organizacion', 'Rut inválido.');
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
        $this->addError('rut_organizacion', 'Rut inválido.');
}



public function validarAportes($attribute, $params){
    $financiamiento_aporte_propio= $this->financiamiento_aporte_propio;
    $financiamiento_aporte_terceros= $this->financiamiento_aporte_terceros;
   /* $financiamiento_aporte_solicitado= $this->financiamiento_aporte_solicitado;
    $financiamiento_aporteTotal_proyecto= $this->financiamiento_aporteTotal_proyecto;

    $aporte_propio_minimo= ($financiamiento_aporteTotal_proyecto)*0.1; //el aporte debe ser minimo el 10% del costo total del proyecto

    if($financiamiento_aporte_propio<$aporte_propio_minimo){
        $this->addError('financiamiento_aporte_propio','El aporte propio debe ser al menos el 10% del costo total del proyecto.');
    }

*/


    if($financiamiento_aporte_propio<=0){
        $this->addError('financiamiento_aporte_propio','El aporte propio debe ser mayor a cero.');
    }



    if($financiamiento_aporte_terceros<0){
        $this->addError('financiamiento_aporte_terceros','El aporte de terceros debe ser mayor o igual a cero.');
    }
 

}

public function validarSuma($attribute, $params){

    $financiamiento_aporte_propio= $this->financiamiento_aporte_propio;
    $financiamiento_aporte_terceros= $this->financiamiento_aporte_terceros;
    $financiamiento_aporte_solicitado= $this->financiamiento_aporte_solicitado;
    $financiamiento_aporteTotal_proyecto= $financiamiento_aporte_solicitado+$financiamiento_aporte_propio+$financiamiento_aporte_terceros;
    $this->financiamiento_aporteTotal_proyecto= $financiamiento_aporteTotal_proyecto.'';

}




 


}
