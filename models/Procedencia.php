<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "procedencia".
 *
 * @property int $id
 * @property string $nombre
 * @property string $contacto
 * @property string $direccion
 *
 * @property Solicitud[] $solicituds
 * @property Solicitudbiopsia[] $solicitudbiopsias
 * @property Solicitudpap[] $solicitudpaps
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Procedencia extends \yii\db\ActiveRecord
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
        return 'procedencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['direccion'], 'string'],
            [['nombre'], 'required'], 
            [['nombre'], 'string', 'max' => 30],
            [['contacto'], 'string', 'max' => 40],
            [['nombre'],'unique'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'contacto' => 'Contacto',
            'direccion' => 'Direccion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicituds()
    {
        return $this->hasMany(Solicitud::className(), ['id_procedencia' => 'id']);
    }


    public function beforeSave($insert){
      if (parent::beforeSave($insert)) {
          $this->nombre = strtoupper($this->nombre);
          return true;
      } else {
          return false;
      }
    }

     public function asociadoaInternacion(){
       //devuelve un true o false
       return $this->getSolicituds()
        ->joinWith('internacion')
        ->exists();
       }
}
