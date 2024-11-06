<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipoactividad".
 *
 * @property int $id
 * @property string $clasificacion
 * @property string $descripcion
 *
 * @property Actividad[] $actividads
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Tipoactividad extends \yii\db\ActiveRecord
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
        return 'tipoactividad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clasificacion', 'descripcion'], 'required'],
            [['clasificacion', 'descripcion'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'clasificacion' => 'Clasificacion',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActividads()
    {
        return $this->hasMany(Actividad::className(), ['id_tipoactividad' => 'id']);
    }
    public function asociadoaActividad(){
      //devuelve un true o false
      return $this->getActividads()
       ->exists();
      }
}
