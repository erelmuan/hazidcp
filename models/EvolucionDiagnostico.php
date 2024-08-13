<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evolucion_diagnostico".
 *
 * @property int $id
 * @property int $id_diagnostico
 * @property int $id_evolucion
 *
 * @property Diagnostico $diagnostico
 * @property Evolucion $evolucion
 */
 use app\components\behaviors\AuditoriaBehaviors;

class EvolucionDiagnostico extends \yii\db\ActiveRecord
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
        return 'evolucion_diagnostico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_diagnostico', 'id_evolucion'], 'required'],
            [['id_diagnostico', 'id_evolucion'], 'default', 'value' => null],
            [['id_diagnostico', 'id_evolucion'], 'integer'],
            [['id_diagnostico'], 'exist', 'skipOnError' => true, 'targetClass' => Diagnostico::className(), 'targetAttribute' => ['id_diagnostico' => 'id']],
            [['id_evolucion'], 'exist', 'skipOnError' => true, 'targetClass' => Evolucion::className(), 'targetAttribute' => ['id_evolucion' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_diagnostico' => 'Id Diagnostico',
            'id_evolucion' => 'Id Evolucion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiagnostico()
    {
        return $this->hasOne(Diagnostico::className(), ['id' => 'id_diagnostico']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvolucion()
    {
        return $this->hasOne(Evolucion::className(), ['id' => 'id_evolucion']);
    }
}
