<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evolucionindicacion_codigo".
 *
 * @property int $id
 * @property int $id_codigo
 * @property int $id_evolucionindicacion
 *
 * @property Codigo $codigo
 * @property Evolucionindicacion $evolucionindicacion
 */
class EvolucionindicacionCodigo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evolucionindicacion_codigo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_codigo', 'id_evolucionindicacion'], 'required'],
            [['id_codigo', 'id_evolucionindicacion'], 'default', 'value' => null],
            [['id_codigo', 'id_evolucionindicacion'], 'integer'],
            [['id_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => Codigo::className(), 'targetAttribute' => ['id_codigo' => 'id']],
            [['id_evolucionindicacion'], 'exist', 'skipOnError' => true, 'targetClass' => Evolucionindicacion::className(), 'targetAttribute' => ['id_evolucionindicacion' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_codigo' => 'Id Codigo',
            'id_evolucionindicacion' => 'Id Evolucionindicacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodigo()
    {
        return $this->hasOne(Codigo::className(), ['id' => 'id_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvolucionindicacion()
    {
        return $this->hasOne(Evolucionindicacion::className(), ['id' => 'id_evolucionindicacion']);
    }
}
