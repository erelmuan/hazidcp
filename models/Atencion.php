<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "atencion".
 *
 * @property int $id
 * @property int $id_usuario
 * @property string $fechahora
 * @property string $personaasesorada
 * @property string $detalles
 * @property int $id_tipoconsulta
 * @property int $id_respuesta
 * @property string $paciente
 * @property string $vinculo
 * @property int $id_servicio
 *
 * @property Paciente $paciente
 * @property Respuesta $respuesta
 * @property Servicio $servicio
 * @property Tipoconsulta $tipoconsulta
 * @property Usuario $usuario
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Atencion extends \yii\db\ActiveRecord
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
        return 'atencion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'fechahora', 'personaasesorada'], 'required'],
            [['id_usuario', 'id_tipoconsulta', 'id_respuesta',  'id_servicio'], 'default', 'value' => null],
            [['id_usuario', 'id_tipoconsulta', 'id_respuesta',  'id_servicio'], 'integer'],
            [['fechahora'], 'safe'],
            [['personaasesorada', 'detalles', 'vinculo', 'paciente'], 'string'],
            [['id_respuesta'], 'exist', 'skipOnError' => true, 'targetClass' => Respuesta::className(), 'targetAttribute' => ['id_respuesta' => 'id']],
            [['id_servicio'], 'exist', 'skipOnError' => true, 'targetClass' => Servicio::className(), 'targetAttribute' => ['id_servicio' => 'id']],
            [['id_tipoconsulta'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoconsulta::className(), 'targetAttribute' => ['id_tipoconsulta' => 'id']],
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
            'id_usuario' => 'Id Usuario',
            'fechahora' => 'Fecha y hora',
            'personaasesorada' => 'Persona asesorada',
            'detalles' => 'Detalles',
            'id_tipoconsulta' => 'Id Tipoconsulta',
            'id_respuesta' => 'Id Respuesta',
            'paciente' => 'Paciente',
            'vinculo' => 'Vinculo',
            'id_servicio' => 'Id Servicio',
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuesta()
    {
        return $this->hasOne(Respuesta::className(), ['id' => 'id_respuesta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicio()
    {
        return $this->hasOne(Servicio::className(), ['id' => 'id_servicio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoconsulta()
    {
        return $this->hasOne(Tipoconsulta::className(), ['id' => 'id_tipoconsulta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }
}
