<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evolucionindicacion".
 *
 * @property int $id_internacion
 * @property string $observacion
 * @property int $id_usuario
 * @property string $nombreusuario
 * @property int $id
 * @property string $tiporegistro
 * @property bool $enfermeria
 * @property string $fechahora
 * @property string $especialidad
 * @property Internacion $internacion
 * @property Usuario $usuario
 * @property EvolucionindicacionCodigo[] $evolucionindicacionCodigos
 */
 use app\components\behaviors\AuditoriaBehaviors;
class Evolucionindicacion extends \yii\db\ActiveRecord
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
        return 'evolucionindicacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_internacion', 'observacion', 'id_usuario', 'tiporegistro', 'fechahora'], 'required'],
            [['id_internacion', 'id_usuario','especialidad'], 'default', 'value' => null],
            [['id_internacion', 'id_usuario'], 'integer'],
            [['observacion', 'nombreusuario', 'tiporegistro','especialidad'], 'string'],
            [['enfermeria'], 'boolean'],
            [['fechahora'], 'safe'],
            [['fechahora'], 'validateFechas'],
            [['id_internacion'], 'exist', 'skipOnError' => true, 'targetClass' => Internacion::className(), 'targetAttribute' => ['id_internacion' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    public function validateFechas($attribute, $params){
      $internacion = Internacion::findOne($this->id_internacion);
        if ($internacion) {
          $f_h_InternacionIngreso = $internacion->fechahoraingreso;
          $f_h_InternacionEgreso = $internacion->fechahoraegreso;
          $f_h_EvolucionIndicacion = $this->fechahora;
          if ($f_h_EvolucionIndicacion < $f_h_InternacionIngreso) {
              $this->addError($attribute, 'La fecha de evolución/indicación no puede ser menor que la fecha de ingreso de la internación.');
          }
          if ($f_h_InternacionEgreso !== null && $f_h_EvolucionIndicacion > $f_h_InternacionEgreso) {
              $this->addError($attribute, 'La fecha de evolución/indicación no puede ser mayor que la fecha de egreso de la internación.');
          }
      } else {
          $this->addError('id_internacion', 'internación no encontrada.');
      }
   }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_internacion' => 'Id Internacion',
            'observacion' => 'Observacion',
            'id_usuario' => 'Id Usuario',
            'nombreusuario' => 'Nombre de usuario',
            'tiporegistro' => 'Tipo de registro',
            'enfermeria' => 'Enfermeria',
            'fechahora' => 'Fecha y hora',
           'especialidad' => 'Especialidad',
           ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInternacion()
    {
        return $this->hasOne(Internacion::className(), ['id' => 'id_internacion']);
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
    public function getEvolucionindicacionCodigos()
    {
        return $this->hasMany(EvolucionindicacionCodigo::className(), ['id_evolucionindicacion' => 'id']);
    }


}
