<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "telefono".
 *
 * @property int $id
 * @property string $numero
 * @property int $id_empresa
 * @property int $id_paciente
 * @property string $fechabaja
 * @property int $id_tipotel
 *
 * @property Empresa $empresa
 * @property Paciente $paciente
 * @property Tipotel $tipotel
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Telefono extends \yii\db\ActiveRecord
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
        return 'telefono';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['numero'], 'string'],
            [['id_empresa', 'id_paciente', 'id_tipotel'], 'default', 'value' => null],
            [['id_empresa', 'id_paciente', 'id_tipotel'], 'integer'],
            [['fechabaja'], 'safe'],
            [['id_empresa'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['id_empresa' => 'id']],
            [['id_paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['id_paciente' => 'id']],
            [['id_tipotel'], 'exist', 'skipOnError' => true, 'targetClass' => Tipotel::className(), 'targetAttribute' => ['id_tipotel' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'numero' => 'Numero',
            'id_empresa' => 'Id Empresa',
            'id_paciente' => 'Id Paciente',
            'fechabaja' => 'Fecha Baja',
            'id_tipotel' => 'Id Tipotel',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresa::className(), ['id' => 'id_empresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['id' => 'id_paciente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipotel()
    {
        return $this->hasOne(Tipotel::className(), ['id' => 'id_tipotel']);
    }
    public function getEmpresas()
    {
      return ArrayHelper::map(Empresa::find()->all(), 'id','denominacion');
    }
    public function getTipotels()
    {
      return ArrayHelper::map(Tipotel::find()->all(), 'id','descripcion');
    }
}
