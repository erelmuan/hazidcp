<?php
namespace app\models;
use app\models\Solicitud;
use app\models\SolicitudDiagnostico;
use Yii;
use yii\base\Model;
use yii\widgets\ActiveForm;

class SolicitudForm extends Model
{
    private $_solicitud; //Atributo donde se guardará el solicitud
    private $_solicitud_diagnosticos; //Atributo donde se guardará la lista de diagnosticos solicitudes
    public function rules()
    {
        return [
            [['Solicitud'], 'required'],
            [['SolicitudDiagnosticos'], 'safe'],
        ];
    }


    public function save()
    {
      //Validar solicitud
       if(!$this->solicitud->validate()) {
            return false;
        }
        //Iniciar transacción
        $transaction = Yii::$app->db->beginTransaction();
        //Guardar solicitud
        if (!$this->solicitud->save()) {
            $transaction->rollBack();
            return false;
        }

        if (!$this->saveSolicitudDiagnosticos()) {
            $transaction->rollBack();
            return false;
        }
        //Finalizar transacción
        $transaction->commit();
        return true;
    }
    public function getSolicitud()
    {
        return $this->_solicitud;
    }

    public function setSolicitud($solicitud)
    {
        if ($solicitud instanceof Solicitud) {
            $this->_solicitud = $solicitud;
        } else if (is_array($solicitud)) {
            $this->_solicitud->setAttributes($solicitud);
        }
    }

    public function setSolicitudDiagnosticos($solicitudDiagnosticos)
      {
          unset($solicitudDiagnosticos['__id__']); // Elimina el producto vacío usado para crear formularios
          $this->_solicitud_diagnosticos = [];
          //Recorrer solicitudDiagnosticos

          foreach ($solicitudDiagnosticos as $key => $solicitudDiagnostico) {

            //Obtiene solicitudSolicitudDiagnostico por clave y lo agrega al atributo productos
              if (is_array($solicitudDiagnostico)) {
                  $this->_solicitud_diagnosticos[$key] = $this->getSolicitudDiagnostico($key);
                  $this->_solicitud_diagnosticos[$key]->setAttributes($solicitudDiagnostico);

              } elseif ($solicitudDiagnosticos instanceof SolicitudDiagnostico) {
                  $this->_solicitud_diagnosticos[$solicitudDiagnostico->id] = $solicitudDiagnostico;
              }
          }
      }




    public function delete()
    {
        //Iniciar transacción
        $transaction = Yii::$app->db->beginTransaction();
        //Eliminar domicilios

        if (!$this->deleteSolictudDiagnosticos()) {
            $transaction->rollBack();
            return false;
        }
        //Eliminar solicitud
        if (!$this->solicitud->delete()) {
            $transaction->rollBack();
            return false;
        }
        //Finalizar transacción
        $transaction->commit();
        return true;
    }


    private function getSolicitudDiagnostico($key)
     {
         $solicitudDiagnostico = $key && strpos($key, 'nuevo') === false ? SolicitudDiagnostico::findOne($key) : false;
         if (!$solicitudDiagnostico) {
             $solicitudDiagnostico = new SolicitudDiagnostico();
             $solicitudDiagnostico->loadDefaultValues();
         }
         return $solicitudDiagnostico;
     }
//  GET ENTIDADES

public function getSolicitudDiagnosticos()
    {
        if ($this->_solicitud_diagnosticos=== null) {
            $this->_solicitud_diagnosticos = $this->solicitud->isNewRecord ? [] : $this->solicitud->solicitudDiagnosticos;
        }

        return $this->_solicitud_diagnosticos;
    }

// SAVE ENTIDADES

public function saveSolicitudDiagnosticos()
    {
        //Arreglo con los productos que ya estan en la db y deben mantenerse
        //Al actualizar la venta actualiza los productos que han sido modificado y elimina aquellos que han sido removidos
        $mantener = [];
        //Recorrer las solicitudesdiagnosticos

        foreach ($this->solicitudDiagnosticos as $solicitudDiagnostico) {
            //Asignar el id de solicitud
            $solicitudDiagnostico->id_solicitud = $this->solicitud->id;
            //Guardar solicitudDiagnostico
            if (!$solicitudDiagnostico->save()) {
              return false;
            }
            //Agregar id del solicitudDiagnostico a lista
            $mantener[] = $solicitudDiagnostico->id;
        }
        //Buscar todos las solicitudDiagnosticos asociados a la venta
        $query = SolicitudDiagnostico::find()->andWhere(['id_solicitud' => $this->solicitud->id]);
        if ($mantener) {
            //Filtrar por las solicitudDiagnosticos que no estan en la lista de mantener
            $query->andWhere(['not in', 'id', $mantener]);
        }
        //Eliminar los solictudDiagnosticos que no estan en la lista
        foreach ($query->all() as $solicitudDiagnostico) {
            $solicitudDiagnostico->delete();
        }
        return true;
    }

//DELETE ENTIDADES


    public function deleteSolictudDiagnosticos()
    {
        //Recoorrer los productos
        foreach ($this->solictudDiagnosticos as $solictudDiagnostico) {
          //Eliminar producto
           if (!$solictudDiagnostico->delete()) {
                return false;
            }
        }
        return true;
    }
}
