<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Domicilio;
/**
 * This is the model class for table "paciente".
 *
 * @property string $nombre
 * @property string $sexo
 * @property string $fechanacimiento
 * @property string $apellido
 * @property string $hc
 * @property int $id_nacionalidad
 * @property int $id_tipodoc
 * @property int $id
 * @property string $numdocumento
 *
 * @property Correo[] $correos
 * @property Domicilio[] $domicilios
 * @property Nacionalidad $nacionalidad
 * @property Tipodoc $tipodoc
 * @property PacienteObrasocial[] $pacienteObrasocials
 * @property Solicitud[] $solicituds
 * @property Telefono[] $telefonos
 * @property Atencion[] $atencions
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Paciente extends \yii\db\ActiveRecord
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
        return 'paciente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'sexo', 'fechanacimiento', 'apellido'], 'required'],
            [['sexo', 'hc', 'numdocumento'], 'string'],
            [['fechanacimiento'], 'safe'],
            [['id_nacionalidad', 'id_tipodoc'], 'default', 'value' => null],
            [['id_nacionalidad', 'id_tipodoc'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['apellido'], 'string', 'max' => 60],
            [['id_tipodoc', 'numdocumento', 'sexo'], 'unique', 'targetAttribute' => ['id_tipodoc', 'numdocumento', 'sexo']],
            [['id_nacionalidad'], 'exist', 'skipOnError' => true, 'targetClass' => Nacionalidad::className(), 'targetAttribute' => ['id_nacionalidad' => 'id']],
            [['id_tipodoc'], 'exist', 'skipOnError' => true, 'targetClass' => Tipodoc::className(), 'targetAttribute' => ['id_tipodoc' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'sexo' => 'Sexo',
            'fechanacimiento' => 'Fecha Nacimiento',
            'apellido' => 'Apellido',
            'hc' => 'Hc',
            'id_nacionalidad' => 'Id Nacionalidad',
            'id_tipodoc' => 'Id Tipodoc',
            'id' => 'ID',
            'numdocumento' => 'Num Documento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCorreos()
    {
        return $this->hasMany(Correo::className(), ['id_paciente' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomicilios()
    {
        return $this->hasMany(Domicilio::className(), ['id_paciente' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNacionalidad()
    {
        return $this->hasOne(Nacionalidad::className(), ['id' => 'id_nacionalidad']);
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
    public function getPacienteObrasocials()
    {
        return $this->hasMany(PacienteObrasocial::className(), ['id_paciente' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicituds()
    {
        return $this->hasMany(Solicitud::className(), ['id_paciente' => 'id']);
    }



    public function getNacionalidades()
    {
        return ArrayHelper::map(Nacionalidad::find()->all(), 'id','gentilicio');
    }


    public function getTipodocs()
    {
        return ArrayHelper::map(Tipodoc::find()->all(), 'id','documento');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTelefonos()
    {
        return $this->hasMany(Telefono::className(), ['id_paciente' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAtencions()
    {
        return $this->hasMany(Atencion::className(), ['id_paciente' => 'id']);
    }

    public function direccionPrincipal()
    {
        $domicilio = Domicilio::find()
            ->where(['id_paciente' => $this->id, 'domicilio.principal' => true])
            ->select(['direccion'])
            ->one(); // Usamos one() para obtener un solo registro

        return $domicilio ? $domicilio->direccion : null; // Devolvemos la dirección o null si no se encontró
    }
    public function barrioPrincipal()
    {
        // Ejecuta la consulta para encontrar el barrio principal
        $domicilio = Domicilio::find()
            ->innerJoin('barrio', 'barrio.id = domicilio.id_barrio') // Ajusta esta condición según sea necesario
            ->where(['id_paciente' => $this->id, 'domicilio.principal' => true])
            ->one(); // Obtener un solo registro

        // Retorna el nombre del barrio si se encuentra, de lo contrario retorna null
        return isset($domicilio->barrio) ? $domicilio->barrio->nombre : null;
    }
    public function solicitudvigente()
    {
        $solicitud = Solicitud::find()
            ->alias('s')
            ->innerJoin('paciente p', 'p.id = s.id_paciente') // Asegúrate de que la relación es correcta
            ->leftJoin('internacion i', 'i.id_solicitud = s.id AND i.fechahoraegreso IS NULL') // Usar leftJoin para incluir solicitudes sin internación
            ->where(['s.id_paciente' => $this->id])
            ->andWhere(['and','id_estado <> 4 ' ])
            ->one(); // Obtener un solo registro

        return $solicitud !== null; // Devolvemos true si se encontró la solicitud, false en caso contrario
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

    public function asociadoaInternacion()
    {
      //devuelve un true o false
      return $this->getSolicituds()
       ->joinWith('internacion')
       ->exists();
    }


}
