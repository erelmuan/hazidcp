<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "codigo".
 *
 * @property int $id
 * @property string $valor
 * @property string $descripcion
 * @property bool $activo
 *
 * @property EvolucionindicacionCodigo[] $evolucionindicacionCodigos
 */
class Codigo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'codigo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['valor', 'descripcion', 'activo'], 'required'],
            [['valor', 'descripcion'], 'string'],
            [['activo'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'valor' => 'Valor',
            'descripcion' => 'Descripcion',
            'activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvolucionindicacionCodigos()
    {
        return $this->hasMany(EvolucionindicacionCodigo::className(), ['id_codigo' => 'id']);
    }
}
