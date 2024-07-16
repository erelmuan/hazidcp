<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nacionalidad".
 *
 * @property int $id
 * @property string $gentilicio
 *
 * @property Paciente[] $pacientes
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Nacionalidad extends \yii\db\ActiveRecord
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
        return 'nacionalidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          [['gentilicio', 'pais'], 'required'],
          [['gentilicio', 'pais'], 'string'],
          [['gentilicio', 'pais'], 'unique', 'targetAttribute' => ['gentilicio', 'pais']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gentilicio' => 'Gentilicio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPacientes()
    {
        return $this->hasMany(Paciente::className(), ['id_nacionalidad' => 'id']);
    }
    /**
      * Verifica si hay pacientes asociados a este modelo
      *
      * @return bool
      */
   public function asociadoaPaciente()
   {
     //devuelve un true o false
     return $this->getPacientes()
      ->exists();
   }

}
