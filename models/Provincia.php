<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provincia".
 *
 * @property int $id
 * @property string $nombre
 * @property string $codigo
 *
 * @property Domicilio[] $domicilios
 * @property Localidad[] $localidads
 * @property Paciente[] $pacientes
 * @property Usuario[] $usuarios
 */
class Provincia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provincia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'codigo'], 'required'],
            [['nombre'], 'unique'],
            [['nombre'], 'string', 'max' => 50],
            [['codigo'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'nombre' => 'Nombre',
            'codigo' => 'Codigo',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalidads()
    {
       return $this->hasMany(Localidad::className(), ['id_provincia' => 'id']);
     }
     /**
       * @return \yii\db\ActiveQuery
      */
   public function getUsuarios() {
     return $this->hasMany(Usuario::className(), ['id_provincia' => 'id']);

   }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomicilios()
    {
        return $this->hasMany(Domicilio::className(), ['id_provincia' => 'id']);
    }


    public function beforeSave($insert)
    {
        // tareas antes de encontrar el objeto
        if (parent::beforeSave($insert)) {
            $this->nombre = strtoupper($this->nombre);
            return true;
        } else {
            return false;
        }
    }

    public function asociadoaDomicilio(){
      //devuelve un true o false
      return $this->getDomicilios()
       ->exists();
      }
}
