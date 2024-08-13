<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reunionfamiliar".
 *
 * @property int $id
 * @property string $lugar
 * @property string $familiares
 * @property string $profesionales
 * @property bool $aceptanacompañamiento
 * @property string $detallesreunion
 * @property int $id_solicitud
 * @property string $fechahora
 *
 * @property Solicitud $solicitud
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Reunionfamiliar extends \yii\db\ActiveRecord
{

  public function behaviors()
{

  return array(
         'AuditoriaBehaviors'=>array(
                'class'=>AuditoriaBehaviors::className(),
                ),
    );
}
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reunionfamiliar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lugar', 'familiares', 'profesionales', 'detallesreunion'], 'string'],
            [['familiares', 'profesionales', 'id_solicitud'], 'required'],
            [['aceptanacompañamiento'], 'boolean'],
            [['id_solicitud'], 'default', 'value' => null],
            [['id_solicitud'], 'integer'],
            [['fechahora'], 'safe'],
            [['fechahora'], 'validateFechas'],
            [['id_solicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitud::className(), 'targetAttribute' => ['id_solicitud' => 'id']],
        ];
    }

    public function validateFechas($attribute, $params){
      $solicitud = Solicitud::findOne($this->id_solicitud);
        if ($solicitud) {
          $fechaSolicitudTimestamp = strtotime($solicitud->fechasolicitud);
          $fechaReunionFamTimestamp = strtotime($this->fechahora);
          if ($fechaReunionFamTimestamp < $fechaSolicitudTimestamp) {
              $this->addError($attribute, 'La fecha de la reunion familiar no puede ser menor que la fecha de solicitud.');
          }
      } else {
          $this->addError('id_solicitud', 'Solicitud no encontrada.');
      }
   }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lugar' => 'Lugar',
            'familiares' => 'Familiares',
            'profesionales' => 'Profesionales',
            'aceptanacompañamiento' => 'Aceptan Acompañamiento',
            'detallesreunion' => 'Detalles Reunion',
            'id_solicitud' => 'Id Solicitud',
            'fechahora' => 'Fechahora',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitud()
    {
        return $this->hasOne(Solicitud::className(), ['id' => 'id_solicitud']);
    }
}
