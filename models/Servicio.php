<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "servicio".
 *
 * @property int $id
 * @property string $nombre
 * @property string $codigo
 *
 * @property Atencion[] $atencions
 * @property Solicitud[] $solicituds
 */
class Servicio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servicio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'unique'],
            [['nombre', 'codigo'], 'string'],
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
            'codigo' => 'Codigo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAtencions()
    {
        return $this->hasMany(Atencion::className(), ['id_servicio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicituds()
    {
        return $this->hasMany(Solicitud::className(), ['id_servicio' => 'id']);
    }

    public function beforeSave($insert){
      if (parent::beforeSave($insert)) {
          $this->nombre = strtoupper($this->nombre);
          return true;
      } else {
          return false;
      }
    }
}
