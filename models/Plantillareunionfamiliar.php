<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plantillareunionfamiliar".
 *
 * @property int $id
 * @property string $codigo
 * @property string $descripcion
 */
class Plantillareunionfamiliar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plantillareunionfamiliar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo', 'descripcion'], 'required'],
            [['descripcion'], 'string'],
            [['codigo'], 'string'],
            [['codigo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'descripcion' => 'Descripcion',
        ];
    }
}
