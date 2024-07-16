<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "diagnostico".
 *
 * @property int $id
 * @property string $descripcion
 * @property string $codigo
 *
 * @property AtencionDiagnostico[] $atencionDiagnosticos
* @property SolicitudDiagnostico[] $solicitudDiagnosticos
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Diagnostico extends \yii\db\ActiveRecord
{
  public function behaviors() {
      return array(
          'AuditoriaBehaviors' => array(
              'class' => AuditoriaBehaviors::className() ,
          ) ,
      );
  }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'diagnostico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'required'],
            [['descripcion', 'codigo'], 'unique', 'targetAttribute' => ['descripcion', 'codigo']], 
            [['descripcion', 'codigo'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'codigo' => 'Codigo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAtencionDiagnosticos()
    {
        return $this->hasMany(AtencionDiagnostico::className(), ['id_diagnostico' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitudDiagnosticos()
    {
       return $this->hasMany(SolicitudDiagnostico::className(), ['id_diagnostico' => 'id']);
    }

    public function asociadoaSolicitud(){
        //devuelve un true o false
        return $this->getSolicitudDiagnosticos()
         ->exists();

    }
}
