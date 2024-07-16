<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "domicilio".
 *
 * @property int $id
 * @property string $direccion
 * @property int $id_barrio
 * @property int $id_paciente
 * @property int $id_provincia
 * @property int $id_localidad
 * @property int $id_tipodom
 * @property string $fechabaja
 * @property bool $principal
 * @property Barrio $barrio
 * @property Localidad $localidad
 * @property Paciente $paciente
 * @property Provincia $provincia
 * @property Tipodom $tipodom
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Domicilio extends \yii\db\ActiveRecord
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
        return 'domicilio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['direccion'], 'string'],
            [['id_barrio', 'id_paciente', 'id_provincia', 'id_localidad', 'id_tipodom'], 'default', 'value' => null],
            [['id_barrio', 'id_paciente', 'id_provincia', 'id_localidad', 'id_tipodom'], 'integer'],
            [['fechabaja'], 'safe'],
            [['principal'], 'boolean'],
            [['id_barrio'], 'exist', 'skipOnError' => true, 'targetClass' => Barrio::className(), 'targetAttribute' => ['id_barrio' => 'id']],
            [['id_localidad'], 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['id_localidad' => 'id']],
            [['id_paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['id_paciente' => 'id']],
            [['id_provincia'], 'exist', 'skipOnError' => true, 'targetClass' => Provincia::className(), 'targetAttribute' => ['id_provincia' => 'id']],
            [['id_tipodom'], 'exist', 'skipOnError' => true, 'targetClass' => Tipodom::className(), 'targetAttribute' => ['id_tipodom' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'direccion' => 'Direccion',
            'id_barrio' => 'Id Barrio',
            'id_paciente' => 'Id Paciente',
            'id_provincia' => 'Id Provincia',
            'id_localidad' => 'Id Localidad',
            'id_tipodom' => 'Id Tipodom',
            'fechabaja' => 'Fecha Baja',
             'principal' => 'Principal',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarrio()
    {
        return $this->hasOne(Barrio::className(), ['id' => 'id_barrio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalidad()
    {
        return $this->hasOne(Localidad::className(), ['id' => 'id_localidad']);
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
    public function getProvincia()
    {
        return $this->hasOne(Provincia::className(), ['id' => 'id_provincia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipodom()
    {
        return $this->hasOne(Tipodom::className(), ['id' => 'id_tipodom']);
    }
    public function getTipodoms()
    {
        return ArrayHelper::map(Tipodom::find()->all(), 'id','descripcion');
    }
    public function getProvincias()
    {
        return ArrayHelper::map(Provincia::find()->all(), 'id','nombre');
    }
    public function getLocalidades($id_provincia)
    {
        return ArrayHelper::map(Localidad::find()->where(['id_provincia'=>$id_provincia])->orderBy(['nombre' => SORT_ASC])->all(), 'id','nombre');
    }
    public function getBarrios($id_localidad)
    {
        $barrios=Barrio::find()->where(['id_localidad'=>$id_localidad])->orderBy(['nombre' => SORT_ASC])->all();
        if(count($barrios)==0){
          return[null,null];
        }else {
          return ArrayHelper::map($barrios, 'id','nombre');

        }
    }

}
