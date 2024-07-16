<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "obrasocial".
 *
 * @property int $id
 * @property string $sigla
 * @property string $denominacion
 * @property string $direccion
 * @property string $telefono
 * @property string $paginaweb
 * @property string $observaciones
 * @property string $correoelectronico
 * @property string $codigo
 * @property PacienteObrasocial[] $pacienteObrasocials
 * @property Provincia $provincia
 * @property Paciente[] $pacientes
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Obrasocial extends \yii\db\ActiveRecord
{
  public function behaviors()
  {

    return array(
           'AuditoriaBehaviors'=>array(
                  'class'=>AuditoriaBehaviors::className(),
                  ),
      );
 }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'obrasocial';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telefono'], 'default', 'value' => null],
            [['telefono'], 'integer'],
            [['observaciones', 'correoelectronico', 'codigo'], 'string'],
            [['sigla'], 'string', 'max' => 15],
            [['denominacion'], 'string', 'max' => 80],
            [['direccion'], 'string', 'max' => 70],
            [['paginaweb'], 'string', 'max' => 35],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'sigla' => 'Sigla',
            'denominacion' => 'Denominacion',
            'direccion' => 'Direccion',
            'telefono' => 'Telefono',
            'paginaweb' => 'Pagina web',
            'observaciones' => 'Observaciones',
            'correoelectronico' => 'Correo electronico',
             'codigo' => 'Código',
        ];
    }



    /**
       * @return \yii\db\ActiveQuery
       */
      public function getPacienteObrasocials()
      {
          return $this->hasMany(PacienteObrasocial::className(), ['id_obrasocial' => 'id']);
      }

      public function beforeSave($insert){
        if (parent::beforeSave($insert)) {
            $this->sigla = strtoupper($this->sigla);
            $this->denominacion = strtoupper($this->denominacion);
            return true;
        } else {
            return false;
        }
      }
      /**
        * Verifica si hay pacientes asociados a este modelo
        *
        * @return bool
        */
     public function asociadoaObrasocial()
     {
       //devuelve un true o false
       return $this->getPacienteObrasocials()
        ->exists();
     }
}
