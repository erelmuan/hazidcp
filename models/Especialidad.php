<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Especialidad".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Evolucionindicacion[] $evolucionindicacions
 * @property Profesional[] $profesionals
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Especialidad extends \yii\db\ActiveRecord
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
        return 'especialidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'string'],
            [['nombre'], 'required'],
            [['nombre'], 'unique'],
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
        ];
    }

    /**
       * @return \yii\db\ActiveQuery
       */
      public function getProfesionals()
      {
          return $this->hasMany(Profesional::className(), ['id_especialidad' => 'id']);
      }
    /**
         * @return \yii\db\ActiveQuery
     */
      public function getEvolucionindicacions()
      {
      return $this->hasMany(Evolucionindicacion::className(), ['id_especialidad' => 'id']);
      }

      public function asociadoaProfesional()
      {
        //devuelve un true o false
        return $this->getProfesionals()
         ->exists();
        }
}
