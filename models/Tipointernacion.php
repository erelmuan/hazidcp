<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipointernacion".
 *
 * @property int $id
 * @property string $descripcion
 * @property Internacion[] $internacions

 */
 use app\components\behaviors\AuditoriaBehaviors;

class Tipointernacion extends \yii\db\ActiveRecord
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
        return 'tipointernacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'required'],
            [['descripcion'], 'string'],
            [['descripcion'], 'unique'],

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
        ];
    }
    /**
    * @return \yii\db\ActiveQuery
    */
   public function getInternacions()
   {
      return $this->hasMany(Internacion::className(), ['id_tipointernacion' => 'id']);
   }
   public function asociadoaInternacion(){
     //devuelve un true o false
     return $this->getInternacions()
      ->exists();
     }

}
