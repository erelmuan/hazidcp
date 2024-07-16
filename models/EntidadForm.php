<?php
namespace app\models;
use app\models\Paciente;
use app\models\Domicilio;
use app\models\Telefono;
use app\models\Correo;
use app\models\PacienteObrasocial;
use Yii;
use yii\base\Model;
use yii\widgets\ActiveForm;

class EntidadForm extends Model
{
    private $_paciente; //Atributo donde se guardará el paciente
    private $_domicilios; //Atributo donde se guardará la lista de domicilios
    private $_telefonos; //Atributo donde se guardará la lista de telefonos
    private $_correos; //Atributo donde se guardará la lista de correos
    private $_pacienteObrasocials; //Atributo donde se guardará la lista de carnets de obras sociales

    public function rules()
    {
        return [
            [['Paciente'], 'required'],
            [['Domicilios'], 'safe'],
            [['Telefonos'], 'safe'],
            [['Correos'], 'safe'],
            [['PacienteObrasocials'], 'safe'],
        ];
    }



    public function saveEntidades($entidades,$modeloEntidad)
    {
        //Arreglo con los entidades que ya estan en la db y deben mantenerse
        //Al actualizar el paciente actualiza los entidades que han sido modificado y elimina aquellos que han sido removidos
        $mantener = [];
        //Recorrer las entidades
        foreach ($this->$entidades as $entidad) {
            //Asignar el id de paciente
            $entidad->id_paciente = $this->paciente->id;
            //Guardar entidad
            if (!$entidad->save()) {
              return false;
            }
            //Agregar id de la entidad a lista
            $mantener[] = $entidad->id;
        }
        //Buscar todas los entidades asociados a la paciente
        $namespace="app\models\\";
        $modelo= $namespace.$modeloEntidad;
        $query = $modelo::find()->andWhere(['id_paciente' => $this->paciente->id]);
        if ($mantener) {
            //Filtrar por los entidades que no estan en la lista de mantener
            $query->andWhere(['not in', 'id', $mantener]);
        }
        //Eliminar los entidades que no estan en la lista
        foreach ($query->all() as $entidad) {
            $entidad->delete();
        }
        return true;
    }
    public function setEntidades($atributo,$entidades,$modelo)
    {

        unset($entidades['__id__']); // Elimina el domicilio vacío usado para crear formularios
        $this->$atributo = [];
        //Recorrer entidades
        foreach ($entidades as $key => $entidad) {
          //Obtiene entidad por clave y lo agrega al atributo entidad
            if (is_array($entidad)) {
                $metodo='get'.$modelo;
                $this->$atributo[$key] = $this->$metodo($key);
                $this->$atributo[$key]->setAttributes($entidad);
            } elseif ($entidades instanceof $modelo) {
                $this->$atributo[$entidad->id] = $entidad;
            }
        }
    }

    public function deleteEntidades($entidades)
    {
        //Recoorrer los entidades
        foreach ($this->$entidades as $entidad) {
          //Eliminar domicilio
           if (!$entidad->delete()) {
                return false;
            }
        }
        return true;
    }


// SECCION ENTIDADES //
    public function getEntidades($entidades)
    {
        $entidad=str_replace(array("_"), '', $entidades);
        if ($this->$entidades=== null) {
            $this->$entidades = $this->paciente->isNewRecord ? [] : $this->paciente->$entidad;
        }
        return $this->$entidades;
    }

    public function getEntidad($key,$modeloEntidad)
    {
        $namespace="app\models\\";
        $modelo= $namespace.$modeloEntidad;
        $entidad = $key && strpos($key, 'nuevo') === false ? $modelo::findOne($key) : false;
        if (!$entidad) {

            $entidad = new $modelo();
            $entidad->loadDefaultValues();
        }
        return $entidad;
    }

}
