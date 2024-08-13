<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "internacion".
 *
 * @property int $id
 * @property int $id_tipointernacion
 * @property string $fechahoraingreso
 * @property int $id_tipoingreso
 * @property string $fechahoraegreso
 * @property int $id_tipoegreso
 * @property int $id_solicitud
 * @property int $id_detalle
 * @property Detalle $detalle

 *
 * @property Evolucionindicacion[] $evolucionindicacions
 * @property Solicitud $solicitud
 * @property Tipoegreso $tipoegreso
 * @property Tipoingreso $tipoingreso
 * @property Tipointernacion $tipointernacion
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Internacion extends \yii\db\ActiveRecord
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
        return 'internacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipointernacion', 'id_tipoingreso', 'id_solicitud','fechahoraingreso'], 'required'],
            [['id_tipointernacion', 'id_tipoingreso', 'id_tipoegreso', 'id_solicitud','id_detalle'], 'default', 'value' => null],
            [['id_tipointernacion', 'id_tipoingreso', 'id_tipoegreso', 'id_solicitud','id_detalle'], 'integer'],
            [['fechahoraingreso', 'fechahoraegreso'], 'safe'],
            [['id_solicitud'], 'unique'],
            ['fechahoraegreso', 'compare', 'compareAttribute' => 'fechahoraingreso', 'operator' => '>=', 'message' => 'La fecha de egreso debe ser posterior o igual a la fecha de ingreso.'],
            [['fechahoraingreso'], 'validateFechas'],
            [['fechahoraegreso'], 'validateFechas'],
            [['id_solicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitud::className(), 'targetAttribute' => ['id_solicitud' => 'id']],
            [['id_tipoegreso'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoegreso::className(), 'targetAttribute' => ['id_tipoegreso' => 'id']],
            [['id_tipoingreso'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoingreso::className(), 'targetAttribute' => ['id_tipoingreso' => 'id']],
            [['id_tipointernacion'], 'exist', 'skipOnError' => true, 'targetClass' => Tipointernacion::className(), 'targetAttribute' => ['id_tipointernacion' => 'id']],
            [['id_detalle'], 'exist', 'skipOnError' => true, 'targetClass' => Detalle::className(), 'targetAttribute' => ['id_detalle' => 'id']],
       ];
    }



    public function validateFechas($attribute, $params){
      $solicitud = Solicitud::findOne($this->id_solicitud);
        if ($solicitud) {
          $fechaSolicitudTimestamp = strtotime($solicitud->fechasolicitud);
          $f_InternacionIngreso = strtotime($this->fechahoraingreso);

          if ($f_InternacionIngreso < $fechaSolicitudTimestamp) {
              $this->addError($attribute, 'La fecha de internación no puede ser menor que la fecha de solicitud.');
          }
          // Obtener las evoluciones relacionadas con esta internación
          $evoluciones = Evolucionindicacion::find()->where(['id_internacion' => $this->id])->all();
          //No necesito formatear la fecha dado que son del mismo tipo.
          foreach ($evoluciones as $evolucion) {
              if ($this->fechahoraegreso != null && $this->fechahoraegreso < $evolucion->fechahora) {
                  $this->addError($attribute, 'La fecha de egreso no puede ser menor a la fecha de alguna evolución.');
                  return;
              }
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
            'id_tipointernacion' => 'Tipo de internacion',
            'fechahoraingreso' => 'Fecha/hora de ingreso',
            'id_tipoingreso' => 'Tipo de ingreso',
            'fechahoraegreso' => 'Fecha/hora de egreso',
            'id_tipoegreso' => 'Tipo de egreso',
            'id_solicitud' => 'Id Solicitud',
            'id_detalle' => 'Id Detalle',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvolucionindicacions()
    {
        return $this->hasMany(Evolucionindicacion::className(), ['id_internacion' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitud()
    {
        return $this->hasOne(Solicitud::className(), ['id' => 'id_solicitud']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoegreso()
    {
        return $this->hasOne(Tipoegreso::className(), ['id' => 'id_tipoegreso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoingreso()
    {
        return $this->hasOne(Tipoingreso::className(), ['id' => 'id_tipoingreso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipointernacion()
    {
        return $this->hasOne(Tipointernacion::className(), ['id' => 'id_tipointernacion']);
    }

    /**
	   * @return \yii\db\ActiveQuery
		 */ 
	  public function getDetalle()
    {
	      return $this->hasOne(Detalle::className(), ['id' => 'id_detalle']);
		 }
}
