<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "programacion".
 *
 * @property int $id
 * @property int $id_solicitud
 * @property int $id_usuario
 * @property string $fecha
 * @property string $turno
 * @property string $practica
 */
class Programacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'programacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_solicitud', 'id_usuario', 'fecha', 'turno'], 'required'],
            [['id_solicitud', 'id_usuario'], 'default', 'value' => null],
            [['id_solicitud', 'id_usuario'], 'integer'],
            [['fecha'], 'safe'],
            [['turno', 'practica'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_solicitud' => 'Id Solicitud',
            'id_usuario' => 'Id Usuario',
            'fecha' => 'Fecha',
            'turno' => 'Turno',
            'practica' => 'Practica',
        ];
    }
}
