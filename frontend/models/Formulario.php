<?php

namespace frontend\models;

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
        ['financiamiento_aporteTotal_proyecto','validarSuma'],
        ['rut_organizacion', 'validateRut1'],
        ['numeroRut_representanteLegal', 'validateRut2'],
        ['telefono_contacto','validateLargoTelefono'],
            [['financiamiento_aporte_propio', 'financiamiento_aporte_terceros', 'financiamiento_aporteTotal_proyecto', 'financiamiento_aporte_solicitado'], 'number','min' => 0, 'max' => 100000000000],
            [['fecha_personalidadJuridica'], 'safe'],
            [['area_subvencion'], 'string', 'max' => 300],
            [['rut_organizacion', 'numeroRut_representanteLegal','numero_unidadVecinal','numero_personalidadJuridica'], 'string', 'max' => 50],
            [['nombre_organizacion','nombre_representanteLegal', 'organismoQueOtorgo_personalidadJuridica', 'domiciolio_representanteLegal', 'nombre_proyecto', 'direccion_proyecto'], 'string', 'max' => 80],
            [['otra_subvencion', 'objetivos_generalesOrganizacion', 'financiamiento_organizacion', 'objetivos_proyecto', 'descripcion_proyecto', 'descripcion_beneficiariosDirectos'], 'string', 'max' => 500],
            [['financiamiento_aporte_propio'], 'number','min'=>0],
            [['telefono_contacto', 'numero_beneficiariosDirectos', 'numero_beneficiariosIndirectos','financiamiento_aporte_terceros'], 'number','min'=>0],
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
            'nombre_organizacion' => 'Nombre de la organización:',
            'rut_organizacion' => 'Rut de la organización:',
            'nombre_representanteLegal' => 'Nombre del representante legal:',
            'area_subvencion' => 'Área de la subvención:',
            'otra_subvencion' => 'Si seleccionó "Otra" descríbala:',
            'telefono_contacto' => 'Teléfono de contacto:',
            'numeroRut_representanteLegal' => 'Rut del representante legal:',
            'numero_personalidadJuridica' => 'Número de la personalidad jurídica:',
            'fecha_personalidadJuridica' => 'Fecha de la personalidad jurídica:',
            'organismoQueOtorgo_personalidadJuridica' => 'Organismo que otorgó la personalidad jurídica:',
            'objetivos_generalesOrganizacion' => 'Objetivos generales de la organización o institución:',
            'financiamiento_organizacion' => 'Financiamiento de la organización:',
            'domiciolio_representanteLegal' => 'Domicilio del representante legal:',
            'nombre_proyecto' => 'Nombre del proyecto:',
            'numero_unidadVecinal' => 'Número de la unidad vecinal:',
            'direccion_proyecto' => 'Dirección del proyecto:',
            'objetivos_proyecto' => 'Objetivos del proyecto:',
            'descripcion_proyecto' => 'Descripción del proyecto:',
            'numero_beneficiariosDirectos' => 'Números de beneficiarios directos:',
            'numero_beneficiariosIndirectos' => 'Números de beneficiarios indirectos:',
            'descripcion_beneficiariosDirectos' => 'Descripción de los beneficiarios directos del proyecto:',
            'financiamiento_aporte_propio' => 'Aporte propio ($):',
            'financiamiento_aporte_terceros' => 'Aporte de terceros ($):',
            'financiamiento_aporte_solicitado' => 'Aporte solicitado ($):',
            'financiamiento_aporteTotal_proyecto' => 'Aporte total del proyecto ($):',
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


    public function validateRut1($attribute, $params) {
        $rut=$this->rut_organizacion;
        $rut = preg_replace('/[\.]/i', '', $rut);
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
        if ($dvr != strtoupper($dv)){
            $this->addError('rut_organizacion', 'Rut inválido.');
        }
    }

    public function validateRut2($attribute, $params) {
        $rut=$this->numeroRut_representanteLegal;
        $rut = preg_replace('/[\.]/i', '', $rut);
        if ( !preg_match("/^[0-9]+-[0-9kK]{1}/",$rut)) {
            $this->addError('numeroRut_representanteLegal', 'Rut inválido.');

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
        if ($dvr != strtoupper($dv)){
            $this->addError('numeroRut_representanteLegal', 'Rut inválido.');
        }
    }    



    public function validarSuma($attribute, $params){

        $financiamiento_aporte_propio= $this->financiamiento_aporte_propio;
        $financiamiento_aporte_terceros= $this->financiamiento_aporte_terceros;
        $financiamiento_aporte_solicitado= $this->financiamiento_aporte_solicitado;
        $financiamiento_aporteTotal_proyecto= $financiamiento_aporte_solicitado+$financiamiento_aporte_propio+$financiamiento_aporte_terceros;
        $this->financiamiento_aporteTotal_proyecto= $financiamiento_aporteTotal_proyecto.'';

    }


    public function validateLargoTelefono($attribute, $params) 
    {
        $telefono_contacto= $this->telefono_contacto;
        $largo=strlen($telefono_contacto);
        if($largo!=9){
             $this->addError('telefono_contacto', 'El teléfono de contacto debe tener nueve dígitos.');
        }



    }

}
