<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipodom".
 *
 * @property int $id
 * @property string $descripcion
 *
 * @property Domicilio[] $domicilios
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Tipodom extends \yii\db\ActiveRecord
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
        return 'tipodom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
            [['descripcion'], 'required'],
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
    public function getDomicilios()
    {
        return $this->hasMany(Domicilio::className(), ['id_tipodom' => 'id']);
    }
}
