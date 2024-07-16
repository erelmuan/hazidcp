<?php
namespace app\controllers;
use Yii;
use app\models\Paciente;
use app\models\PacienteSearch;
use app\models\Provincia;
use app\models\Domicilio;
use app\models\Localidad;
use app\models\Obrasocial;
use app\models\PacienteObrasocial;
use app\controllers\PacienteObrasocialController;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use app\components\Metodos\Metodos;
use app\models\PacienteForm;
use app\models\Solicitud;
/**
 * PacienteController implements the CRUD actions for Paciente model.
 */
class PacienteController extends Controller {
  // behaviors heredado class CONTOLLER (accesos seguridad)


    public function actionSearch() {
        $searchModelPac = new PacienteSearch();
        $searchModelPac->scenario = "search";
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $searchModelPac->load(\Yii::$app->request->get());
            if ($searchModelPac->validate()) {
                $dataProviderPac = $searchModelPac->search(\Yii::$app
                    ->request
                    ->get());
                if ($dataProviderPac->totalCount == 0) return Json::encode(['status' => 'error', 'mensaje' => "No se encontro el paciente"]);
                else return Json::encode(["nombre" => $dataProviderPac->getModels() [0]['nombre'], "apellido" => $dataProviderPac->getModels() [0]['apellido'], "id" => $dataProviderPac->getModels() [0]['id']]);
            }
            else {
                $errors = $searchModelPac->getErrors();
                return Json::encode(['status' => 'error', 'mensaje' => $errors['fechanacimiento'][0]]);
            }
        }
    }
    /**
     * Lists all Paciente models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PacienteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, ]);
    }
    /**
     * Displays a single Paciente model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if($model->fechanacimiento !== NULL){
          $model->fechanacimiento = date('d/m/Y', strtotime($model->fechanacimiento));
        }
        if ($request->isAjax) {
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            return ['title' => "Paciente #" . $id, 'content' => $this->renderAjax('_detalleview', ['model' => $model ])
            , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        else {
            return $this->render('view', ['model' => $model ]);
        }
    }

    public function validarPrincipal($domicilios){
      //Contabiliza la cantidad de domicilios principales
      $contabilizador=0;
      foreach ($domicilios as $domicilio) {
          //variable booleana, si esta como principal tiene que ser true
            if($domicilio['principal'] == true){
              $contabilizador++;
          }
      }
        if ($contabilizador == 0){
          $this->setearMensajeError('Debe elegir un domicilio como principal');
          return false;
        }
        if ($contabilizador >1){
          $this->setearMensajeError('Solo puede tener un domicilio principal');
          return false;
        }
        return true ;
        //VALIDAR TAMBIEN QUE NO SEA DOMICILIO PRINCIPAL Y ESTE DADO DE BAJA

    }


    public function actionCreate() {
        $model = new PacienteForm();
        $model->paciente = new Paciente;
        $model->paciente->loadDefaultValues();
        //llama a todos los atributos set del modelo
        $model->setAttributes(Yii::$app->request->post());

        if (Yii::$app->request->post() ) {
            //Se valida que si se crea un domicilio debe estar como principal, si hay mas, al menos uno debe ser principal
            if(isset($_POST['Domicilios']) && !$this->validarPrincipal($_POST['Domicilios'])) {
              return $this->render('create', ['model' => $model]);
            }

            if($model->save()){
              //Si elegimos en el formulario la opcion de "crear e ir al registro"
              if($_POST['registro']){
                return $this->redirect(['solicitud/create', 'id_paciente' => $model->paciente->id]);
              }else {
                return $this->redirect(['view', 'id' => $model->paciente->id]);
              }
            }
            else {
                return $this->render('create', ['model' => $model]);
              }
        }
        else {
            return $this->render('create', ['model' => $model]);
          }
    }


      public function actualizarDireccion($paciente){
        $solicitud = Solicitud::find()

              ->leftJoin('internacion', 'internacion.id_solicitud = solicitud.id AND internacion.fechahoraegreso IS NULL') // Usar leftJoin para incluir solicitudes sin internación
              ->where(['solicitud.id_paciente' => $paciente->id])
              ->andWhere(['not in', 'solicitud.id_estado', [2, 4]]) // Excluir estados rechazado y anulado
              ->one(); // Obtener un solo registro
            if($solicitud){
                $solicitud->direccion = $paciente->direccionPrincipal();
                $solicitud->barrio = $paciente->barrioPrincipal();
                if (!$solicitud->save()) {
                      // Registrar el error en el log
                      Yii::error("Error al guardar la solicitud: " . implode(", ", $solicitud->getErrors()), __METHOD__);
                      // Lanzar una excepción con los detalles del error
                      throw new \yii\web\HttpException(500, "Error al actualizar la dirección: " . implode(", ", $solicitud->getFirstErrors()));
                  }
              }
        }


    /**
     * Updates an existing Paciente model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = new PacienteForm();
        $model->paciente = $this->findModel($id);
        //llama a todos los atributos set del modelo
        $model->setAttributes(Yii::$app->request->post());
        if (Yii::$app->request->post() ) {
            //Se valida que si se crea un domicilio debe estar como principal, si hay mas, al menos uno debe ser principal
            if(isset($_POST['Domicilios']) && !$this->validarPrincipal($_POST['Domicilios'])) {
                return $this->render('update', ['model' => $model]);
            }
            if($model->save()){
              //actualizar la direccion de la internacion vigente (en caso de tenerla)
              try {
                  $this->actualizarDireccion($model->paciente);
              } catch (\yii\web\HttpException $e) {
                  Yii::$app->session->setFlash('error', $e->getMessage());
                  return $this->render('update', ['model' => $model]);
              }
              if($_POST['registro']==1){
                return $this->redirect(['solicitud/create', 'id_paciente' => $model->paciente->id]);
              }else {
                return $this->redirect(['view', 'id' => $model->paciente->id]);
              }
            }
            else {
                return $this->render('update', ['model' => $model  ]);
            }
        }
        else {
            return $this->render('update', ['model' => $model  ]);
        }

    }
    /**
     * Delete an existing Paciente model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
          if (Solicitud::find()->where(['id_paciente'=>$id])->count()>0 ){
            return ['title' => "Eliminar paciente #" . $id, 'content' => 'No se puede eliminar el paciente porque esta asociado a un registro', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
          }

        if ($request->isAjax) {
            /*
             *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;

                \Yii::$app ->db->createCommand()->delete('paciente_obrasocial', ['id_paciente' => $id])->execute();
                \Yii::$app ->db->createCommand()->delete('domicilio', ['id_paciente' => $id])->execute();
                \Yii::$app ->db->createCommand()->delete('telefono', ['id_paciente' => $id])->execute();
                \Yii::$app ->db->createCommand()->delete('correo', ['id_paciente' => $id])->execute();

                if ($this->findModel($id)->delete()) {
                  $this->setearMensajeExito('El registro se eliminó correctamente.');
                  return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax', 'metodo' => 'delete'];
                }
        }
        else {
            /*
             *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    public function actionPuco() {
        //fin
        return $this->render('puco');
    }
    public function actionPacienteregistro() {
      ////////////PACIENTE/////////////////
      $searchModel = new PacienteSearch();

      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('pacienteregistro', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, ]);
    }

    public function actionSubcat() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $id_provincia = $parents[0];
                //obtener todas las localidades por el id de la provincia
                $Arraylocalidades = Localidad::findall(['id_provincia' => $id_provincia]);
                ArrayHelper::multisort($Arraylocalidades, ['nombre'], [SORT_ASC]);
                $i = 0;
                $localidades = [];
                foreach ($Arraylocalidades as $key => $value) {
                    $localidades[$i] = array(
                        'id' => $value['id'],
                        'name' => $value['nombre']
                    );
                    $i = $i + 1;
                }
                $out = [['id' => '<sub-cat-id-1>', 'name' => '<sub-cat-name1>'], ['id' => '<sub-cat_id_2>', 'name' => '<sub-cat-name2>']];
                return Json::encode(['output' => $localidades]);
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }
    /**
     * Finds the Paciente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Paciente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Paciente::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
