<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "registrosesion".
 *
 * @property int $id
 * @property int $id_usuario
 * @property string $iniciosesion
 * @property string $ip
 * @property string $informacionusuario
 * @property string $cookie
 * @property string $cierresesion
 *
 * @property Usuario $usuario
 */
class Registrosesion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registrosesion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'iniciosesion'], 'required'],
            [['id_usuario'], 'default', 'value' => null],
            [['id_usuario'], 'integer'],
            [['iniciosesion', 'cierresesion'], 'safe'],
            [['ip', 'informacionusuario', 'cookie'], 'string'],
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
            'id_usuario' => 'Id Usuario',
            'iniciosesion' => 'Inicio Sesion',
            'ip' => 'Ip',
            'informacionusuario' => 'Informacion Usuario',
            'cookie' => 'Cookie',
            'cierresesion' => 'Cierre Sesion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }
}
