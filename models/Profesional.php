<?php

namespace app\models;
use app\components\behaviors\AuditoriaBehaviors;
use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "profesional".
 *
 * @property string $apellido
 * @property string $nombre
 * @property int $id
 * @property string $numdocumento
 * @property string $matricula
 * @property int $id_especialidad
 * @property int $id_usuario
 * @property Usuario $usuario
 * @property string $tipodoc
 * @property Especialidad $especialidad
 * @property Solicitud[] $solicituds
 * @property int $id_prestador
 * @property Prestador $prestador
 * @property bool $visualizar
 */
class Profesional extends \yii\db\ActiveRecord
{
  public function behaviors()
  {

    return array(
           'AuditoriaBehaviors'=>array(
                  'class'=>AuditoriaBehaviors::className(),
                  ),
      );
 }

 private $_nombre;
 private $_apellido;
 private $_numdocumento;
 private $_tipodoc;


    public function getNombre()
    {
        if ($this->_nombre === null && $this->prestador !== null) {
            $this->_nombre = $this->prestador->nombre;
        }
        return $this->_nombre;
    }
    public function getApellido()
    {
        if ($this->_apellido === null && $this->prestador !== null) {
            $this->_apellido = $this->prestador->apellido;
        }
        return $this->_apellido;
    }

     public function getNumdocumento()
     {
         if ($this->_numdocumento === null && $this->prestador !== null) {
             $this->_numdocumento = $this->prestador->numdocumento;
         }
         return $this->_numdocumento;
     }
     public function getTipodoc()
     {
         if ($this->_tipodoc === null && $this->prestador !== null) {
             $this->_tipodoc = $this->prestador->tipodoc->documento;
         }
         return $this->_tipodoc;
     }
     //SETTER
     public function setNombre($value)
      {
        $this->_nombre = $value;
      }
     public function setApellido($value)
      {
       $this->_apellido = $value;
     }
     public function setNumdocumento($value)
      {
        $this->_numdocumento= $value;
      }
     public function setTipodoc($value)
      {
       $this->_tipodoc = $value;
     }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profesional';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apellido', 'nombre'], 'required'],
            [['matricula'], 'string'],
            [['tipodoc', 'id_especialidad','id_prestador'], 'default', 'value' => null],
            [[ 'id_especialidad','id_usuario','id_prestador'], 'integer'],
            [['apellido', 'nombre'], 'string', 'max' => 35],
            [['numdocumento'], 'string', 'max' => 15],
            [['id_usuario'], 'unique'],
            [['visualizar'], 'boolean'],
            [['id_especialidad'], 'exist', 'skipOnError' => true, 'targetClass' => Especialidad::className(), 'targetAttribute' => ['id_especialidad' => 'id']],
 	          [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
 		        [['id_prestador'], 'exist', 'skipOnError' => true, 'targetClass' => Prestador::className(), 'targetAttribute' => ['id_prestador' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'apellido' => 'Apellido',
            'nombre' => 'Nombre',
            'id' => 'ID',
            'numdocumento' => 'N° doc.',
            'matricula' => 'Matricula',
            'tipodoc' => 'Tipo de documento',
            'id_especialidad' => 'Especialidad',
             'visualizar' => 'Visualizar',
        ];
    }




    /**
     * @return \yii\db\ActiveQuery
     */
    public function getespecialidad()
    {
        return $this->hasOne(Especialidad::className(), ['id' => 'id_especialidad']);
    }

    public function getEspecialidades() {
            return ArrayHelper::map(Especialidad::find()->all(), 'id','nombre');

        }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicituds()
    {
        return $this->hasMany(Solicitud::className(), ['id_profesional' => 'id']);
    }


    public function Estudios()
   {
       if (!isset($this->id))
         return false;
     $id= $this->id;
     $estudiosPap = Solicitudpap::find()
      ->innerJoinWith('profesional', 'profesional.id = solicitudpap.id_profesional')
      ->innerJoinWith('pap', 'pap.id_solicitudpap = solicitudpap.id')
      //Estado 2 pap
      ->where(['and', "profesional.id=".$id, "pap.id_estado=2"])
      ->count('*');
      if ($estudiosPap >0)
          return true;
      $estudiosBiopsia = Solicitudbiopsia::find()
       ->innerJoinWith('profesional', 'profesional.id = solicitudbiopsia.id_profesional')
       ->innerJoinWith('biopsia', 'biopsia.id_solicitudbiopsia = solicitudbiopsia.id')
       ->where(['and', "profesional.id=".$id, "biopsia.id_estado=2"])
       ->count('*');

     if ($estudiosBiopsia >0)
         return true;

     return false;
   }
   /**
		    * @return \yii\db\ActiveQuery
		    */
		   public function getPrestador()
		   {
		       return $this->hasOne(Prestador::className(), ['id' => 'id_prestador']);
		   }

       /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuario()
    {
       return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }

    public function getAsociadoInternacion()
    {
      //devuelve un true o false
      return $this->getSolicituds()
       ->joinWith('internacion')
       ->exists();
      }

}
