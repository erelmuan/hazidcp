<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalle".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $id_tipoegreso
 *
 * @property Tipoegreso $tipoegreso
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Detalle extends \yii\db\ActiveRecord
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
        return 'detalle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'id_tipoegreso'], 'required'],
            [['descripcion'], 'string'],
            [['id_tipoegreso'], 'default', 'value' => null],
            [['id_tipoegreso'], 'integer'],
            [['descripcion', 'id_tipoegreso'], 'unique', 'targetAttribute' => ['descripcion', 'id_tipoegreso']],
            [['id_tipoegreso'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoegreso::className(), 'targetAttribute' => ['id_tipoegreso' => 'id']],
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
            'id_tipoegreso' => 'Id Tipoegreso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoegreso()
    {
        return $this->hasOne(Tipoegreso::className(), ['id' => 'id_tipoegreso']);
    }
}
