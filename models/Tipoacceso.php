<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_acceso".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Modulo[] $modulos
 */
class Tipoacceso extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipoacceso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string'],
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
    public function getModulos()
    {
        return $this->hasMany(Modulo::className(), ['id_tipo_acceso' => 'id']);
    }
}
