<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actividad".
 *
 * @property int $id
 * @property int $id_tipoactividad
 * @property string $clasificacion
 * @property string $paciente
 * @property string $observacion
 * @property string $fechahora
 * @property int $id_usuario
 *
 * @property Tipoactividad $tipoactividad
 * @property Usuario $usuario
 */
class Actividad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'actividad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipoactividad', 'clasificacion', 'fechahora' ,'id_usuario'], 'required'],
            [['id_tipoactividad', 'id_usuario'], 'default', 'value' => null],
            [['id_tipoactividad', 'id_usuario'], 'integer'],
            [['clasificacion', 'paciente', 'observacion'], 'string'],
            [['fechahora'], 'safe'],
            [['id_tipoactividad'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoactividad::className(), 'targetAttribute' => ['id_tipoactividad' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tipoactividad' => 'Tipo de actividad',
            'clasificacion' => 'Clasificacion',
            'paciente' => 'Paciente',
            'observacion' => 'Observacion',
            'fechahora' => 'Fecha/hora',
            'id_usuario' => 'Id Usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoactividad()
    {
        return $this->hasOne(Tipoactividad::className(), ['id' => 'id_tipoactividad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }
}
