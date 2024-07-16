<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "modulo".
* @property Permiso[] $permisos
 * @property int $id
 * @property string $nombre
 * @property int $id_tipoacceso
 * @property Tipoacceso $tipoAcceso
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Modulo extends \yii\db\ActiveRecord
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
        return 'modulo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre','id_tipoacceso'], 'required'],
            [['id_tipoacceso'], 'default', 'value' => null],
            [['id_tipoacceso'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['nombre', 'id_tipoacceso'], 'unique', 'targetAttribute' => ['nombre', 'id_tipoacceso'], 'message' => 'Esta combinación ya existe.'],
            [['id_tipoacceso'], 'integer'],
            [['id_tipoacceso'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoacceso::className(), 'targetAttribute' => ['id_tipoacceso' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'nombre' => 'Nombre',
            'id_tipoacceso' => 'Id Tipo Acceso',
        ];
    }

    public function attributeView()
    {
        return [

      'id',
      'nombre',
      'id_tipoacceso'
        ];
    }

    public function attributeColumns()
    {
        return [
          [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'id',
          ],
          [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'nombre',
          ],
          [
            'class'=> '\kartik\grid\DataColumn',
            'label'=> 'Tipo de acceso',
            'attribute'=>'tipoacceso',
            'value'=>'tipoAcceso.nombre',
          ],
        ];
    }

    public function beforeSave($insert){
    //DE FORMA INDIVIDUAL
     if ($insert) {
      $this->nombre = strtolower($this->nombre);
    }
      return parent::beforeSave($insert);
    }

    /**
  		    * @return \yii\db\ActiveQuery
  		    */
  		 public function getPermisos()
  		 {
         return $this->hasMany(Permiso::className(), ['id_modulo' => 'id']);
       }

       /**
  		    * @return \yii\db\ActiveQuery
  		    */
  	  public function getTipoAcceso()
    {
       return $this->hasOne(Tipoacceso::className(), ['id' => 'id_tipoacceso']);
       }

}
