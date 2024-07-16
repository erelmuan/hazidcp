<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipotel".
 *
 * @property int $id
 * @property string $descripcion
 *
 * @property Telefono $telefono
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Tipotel extends \yii\db\ActiveRecord
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
        return 'tipotel';
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
    public function getTelefono()
    {
        return $this->hasOne(Telefono::className(), ['id' => 'id']);
    }
}
