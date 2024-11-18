<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "actividad".
 *
 * @property int $id
 * @property int $id_tipoactividad
 * @property string $clasificacion
 * @property string $pacienteint
 * @property string $observacion
 * @property string $fechahora
 * @property int $id_usuario
 * @property int $id_paciente
 * @property Paciente $paciente
 *
 * @property Tipoactividad $tipoactividad
 * @property Usuario $usuario
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Actividad extends \yii\db\ActiveRecord
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
        return 'actividad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipoactividad', 'clasificacion', 'fechahora' ,'id_usuario'], 'required'],
            [['id_tipoactividad', 'id_usuario', 'id_paciente'], 'default', 'value' => null],
            [['id_tipoactividad', 'id_usuario', 'id_paciente'], 'integer'],
            [['clasificacion', 'pacienteint', 'observacion'], 'string'],
            [['fechahora'], 'safe'],
            [['id_tipoactividad'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoactividad::className(), 'targetAttribute' => ['id_tipoactividad' => 'id']],
 		           [['id_paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['id_paciente' => 'id']],
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
            'id_tipoactividad' => 'Tipo de actividad',
            'clasificacion' => 'Clasificacion',
            'pacienteint' => 'Paciente',
            'observacion' => 'Observacion',
            'fechahora' => 'Fecha/hora',
            'id_usuario' => 'Id Usuario',
             'id_paciente' => 'Id Paciente',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoactividad()
    {
        return $this->hasOne(Tipoactividad::className(), ['id' => 'id_tipoactividad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }
    /**
   * @return \yii\db\ActiveQuery
   */
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['id' => 'id_paciente']);
    }
}
