<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "prestador".
 *
 * @property int $id
 * @property string $nombre
 * @property string $apellido
 * @property int $id_tipodoc
 * @property string $numdocumento
 *
 * @property Tipodoc $tipodoc
 * @property Profesional[] $profesionals
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Prestador extends \yii\db\ActiveRecord
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
        return 'prestador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido'], 'required'],
            [['nombre', 'apellido', 'numdocumento'], 'string'],
            [['id_tipodoc'], 'default', 'value' => null],
            [['id_tipodoc'], 'integer'],
            [['id_tipodoc'], 'exist', 'skipOnError' => true, 'targetClass' => Tipodoc::className(), 'targetAttribute' => ['id_tipodoc' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'id_tipodoc' => 'Id Tipodoc',
            'numdocumento' => 'Numero de doc.',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipodoc()
    {
        return $this->hasOne(Tipodoc::className(), ['id' => 'id_tipodoc']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfesionals()
    {
        return $this->hasMany(Profesional::className(), ['id_prestador' => 'id']);
    }
    public function getTipodocs() {
            return ArrayHelper::map(Tipodoc::find()->all(), 'id','documento');

        }


        /**
   * Verifica si el prestador tiene al menos una solicitud.
       * @return bool
       */
      public function getAsociadoInternacion()
      {
        //devuelve un true o false
        return $this->getProfesionals()
         ->joinWith(['solicituds' => function ($query) {
             $query->joinWith('internacion');
         }])
         ->where(['is not', 'internacion.id', null])
         ->exists();

        }

        public function beforeSave($insert)
        {
            // tareas antes de encontrar el objeto
            if (parent::beforeSave($insert)) {
                $this->nombre = strtoupper($this->nombre);
                $this->apellido = strtoupper($this->apellido);
                return true;
            } else {
                return false;
            }
        }



}
