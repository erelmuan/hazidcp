<?php
namespace app\models;
use app\models\Paciente;
use app\models\Telefono;
use app\models\Domicilio;
use app\models\Correo;
use app\models\PacienteObrasocial;
use Yii;
use yii\base\Model;
use yii\widgets\ActiveForm;

class PacienteForm extends EntidadForm
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


    public function save()
    {
      //Validar paciente
       if(!$this->paciente->validate()) {
            return false;
        }
        //Iniciar transacción
        $transaction = Yii::$app->db->beginTransaction();
        //Guardar paciente
        if (!$this->paciente->save()) {
            $transaction->rollBack();
            return false;
        }
        //Guardar lista de las entidades
        if (!$this->saveDomicilios()) {
            $transaction->rollBack();
            return false;
        }
        if (!$this->saveTelefonos()) {
            $transaction->rollBack();
            return false;
        }
        if (!$this->saveCorreos()) {
            $transaction->rollBack();
            return false;
        }
        if (!$this->savePacienteObrasocials()) {
            $transaction->rollBack();
            return false;
        }
        //Finalizar transacción
        $transaction->commit();
        return true;
    }
    public function getPaciente()
    {
        return $this->_paciente;
    }

    public function setPaciente($paciente)
    {
        if ($paciente instanceof Paciente) {
            $this->_paciente = $paciente;
        } else if (is_array($paciente)) {
            $this->_paciente->setAttributes($paciente);
        }
    }
    //NO SE ESTA USANDO PORQUE SE REALIZA BAJAS LOGIAS, SE DEJA POR UN USO POSIBLE A FUTURO
    public function delete()
    {
        //Iniciar transacción
        $transaction = Yii::$app->db->beginTransaction();
        //Eliminar domicilios
        if (!$this->deleteDomicilios()) {
            $transaction->rollBack();
            return false;
        }
        if (!$this->deleteTelefonos()) {
            $transaction->rollBack();
            return false;
        }
        if (!$this->deleteCorreos()) {
            $transaction->rollBack();
            return false;
        }
        if (!$this->deletePacienteObrasocials()) {
            $transaction->rollBack();
            return false;
        }
        //Eliminar paciente
        if (!$this->paciente->delete()) {
            $transaction->rollBack();
            return false;
        }
        //Finalizar transacción
        $transaction->commit();
        return true;
    }



//  GET ENTIDADES
    public function getDomicilios(){
      return $this->getEntidades('_domicilios');
    }
    public function getTelefonos(){
      return $this->getEntidades('_telefonos');
    }
    public function getCorreos(){
      return $this->getEntidades('_correos');
    }
    public function getPacienteObrasocials(){
      return $this->getEntidades('_pacienteObrasocials');
    }
// SAVE ENTIDADES
    public function saveDomicilios(){
       return $this->saveEntidades('domicilios','Domicilio');
    }
    public function saveTelefonos(){
       return $this->saveEntidades('telefonos','Telefono');
    }
    public function saveCorreos(){
       return $this->saveEntidades('correos','Correo');
    }
    public function savePacienteObrasocials(){
       return $this->saveEntidades('pacienteObrasocials','PacienteObrasocial');
    }
// SET ENTIDADES
    public function setDomicilios($domicilios){
       $this->setEntidades('_domicilios',$domicilios, 'Domicilio');
    }
    public function setTelefonos($telefonos){
       $this->setEntidades('_telefonos',$telefonos, 'Telefono');
    }
    public function setCorreos($correos){
       $this->setEntidades('_correos',$correos, 'Correo');
    }
    public function setPacienteObrasocials($pacienteObrasocials){
       $this->setEntidades('_pacienteObrasocials',$pacienteObrasocials, 'PacienteObrasocial');
    }

//GET ENTIDADES - POR EL MOMENTO NO SE ESTA USANDO, CHEQUEAR ESTO DESDE LA VISTA
    public function getDomicilio($key){
      return $this->getEntidad($key,'Domicilio');
    }
    public function getTelefono($key){
      return $this->getEntidad($key,'Telefono');
    }
    public function getCorreo($key){
      return $this->getEntidad($key,'Correo');
    }
    public function getPacienteObrasocial($key){
      return $this->getEntidad($key,'PacienteObrasocial');
    }
//DELETE ENTIDADES - NO SE ESTA USANDO
    public function deleteDomicilios()  {
       $this->deleteEntidades('domicilios');
    }
    public function deleteTelefonos()  {
       $this->deleteEntidades('telefonos');
    }
    public function deleteCorreos()  {
       $this->deleteEntidades('correos');
    }
    public function deletePacienteObrasocial()  {
       $this->deleteEntidades('pacienteObrasocials');
    }

}
