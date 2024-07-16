<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "respuesta".
 *
 * @property int $id
 * @property string $descripcion
 * @property string $detalles
 *
 * @property Atencion[] $atencions
 */
class Respuesta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'respuesta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'required'],
            [['descripcion', 'detalles'], 'string'],
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
            'detalles' => 'Detalles',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAtencions()
    {
        return $this->hasMany(Atencion::className(), ['id_respuesta' => 'id']);
    }
    public function asociadoaAtencion(){
      //devuelve un true o false
      return $this->getAtencions()
       ->exists();
      }
}
