<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "solicitud_diagnostico".
 *
 * @property int $id
 * @property int $id_diagnostico
 * @property int $id_solicitud
 * @property bool $principal
 * @property string $registro_usuario
 * @property string $registro_tiempo
 * @property bool $diag_internacion Se utiliza para distinguir si el diagnostico si se carga desde la internancion
 *
 * @property Diagnostico $diagnostico
 * @property Solicitud $solicitud
 */
class SolicitudDiagnostico extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'solicitud_diagnostico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_diagnostico', 'id_solicitud'], 'required'],
            [['id_diagnostico', 'id_solicitud'], 'default', 'value' => null],
            [['id_diagnostico', 'id_solicitud'], 'integer'],
            [['principal', 'diag_internacion'], 'boolean'],
            [['registro_usuario'], 'string'],
            [['registro_tiempo'], 'safe'],
            [['id_solicitud', 'principal', 'diag_internacion'], 'unique', 'targetAttribute' => ['id_solicitud', 'principal', 'diag_internacion']],
            [['id_diagnostico'], 'exist', 'skipOnError' => true, 'targetClass' => Diagnostico::className(), 'targetAttribute' => ['id_diagnostico' => 'id']],
            [['id_solicitud'], 'exist', 'skipOnError' => true, 'targetClass' => Solicitud::className(), 'targetAttribute' => ['id_solicitud' => 'id']],
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
            'id_solicitud' => 'Id Solicitud',
            'principal' => 'Principal',
            'registro_usuario' => 'Registro Usuario',
            'registro_tiempo' => 'Registro Tiempo',
            'diag_internacion' => 'Diag Internacion',
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
    public function getSolicitud()
    {
        return $this->hasOne(Solicitud::className(), ['id' => 'id_solicitud']);
    }
}
