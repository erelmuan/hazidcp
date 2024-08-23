<?php
namespace app\controllers;
use Yii;
use app\models\Solicitud;
use app\models\SolicitudSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\PacienteSearch;
use app\models\Paciente;
use app\models\ProfesionalSearch;
use app\models\Profesional;
use app\models\Diagnostico;
use app\models\DiagnosticoSearch;
use app\models\SolicitudForm;
use app\components\Metodos\Metodos;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
/**
 * SolicitudController implements the CRUD actions for Solicitud model.
 */
class SolicitudController extends Controller {
  // behaviors heredado class CONTOLLER (accesos seguridad)


    public function actionIndex() {
        $model = new Solicitud();
        $searchModel = new SolicitudSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, null);
        $dataProvider->pagination->pageSize = 7;
        $columnas = Metodos::obtenerColumnas($model);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'columns' => $columnas, ]);
    }
    public function actionAnulado() {
        $model = new Solicitud();
        $searchModel = new SolicitudSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'anulado');
        $dataProvider->pagination->pageSize = 7;
        $columnas = Metodos::obtenerColumnas($model);
        return $this->render('anulado', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'columns' => $columnas, ]);
    }




    /**
     * Displays a single Solicitud model.
     * @param integer $id
     * @return mixed
     */

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "SOLICITUD#".$id,
                    'content'=>$this->renderAjax('_detalleview', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];
        }else{
            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }

    public function validarPrincipal($diagnosticos){
      //Contabiliza la cantidad de domicilios principales
      $contabilizador=0;
      foreach ($diagnosticos as $diagnostico) {
          //variable booleana, si esta como principal tiene que ser true
            if($diagnostico['principal'] == true){
              $contabilizador++;
          }
      }
        if ($contabilizador == 0){
          $this->setearMensajeError('Debe elegir un diagnostico como principal');
          return false;
        }
        if ($contabilizador >1){
          $this->setearMensajeError('Solo puede tener un diagnostico principal');
          return false;
        }
        return true ;
        //VALIDAR TAMBIEN QUE NO SEA DOMICILIO PRINCIPAL Y ESTE DADO DE BAJA

    }

    public function devolverModelos(){

      ////////////PROFESIONAL/////////////////
      $searchModelProf = new ProfesionalSearch();
      $dataProviderProf = $searchModelProf->search(Yii::$app->request->queryParams,"SOLO_VER_PROFESIONALES_SOLICITANTES");
      $dataProviderProf ->pagination->pageSize = 7;
      ////////////PROFESIONAL A CARGO/////////////////
      $searchModelPAC = new ProfesionalSearch();
      $dataProviderPAC = $searchModelPAC->search(Yii::$app->request->queryParams,"SOLO_VER_PROFESIONALES_A_CARGO");
      $dataProviderPAC ->pagination->pageSize = 7;
    ////////////DIAGNOSTICO/////////////////
      $searchModelDiag = new DiagnosticoSearch();
      $dataProviderDiag = $searchModelDiag->search(Yii::$app->request->queryParams,false);
      $dataProviderDiag->pagination->pageSize = 7;
      $searchModel=[
              'searchModelProf' => $searchModelProf ,
              'dataProviderProf' => $dataProviderProf ,
              'searchModelDiag' => $searchModelDiag,
              'dataProviderDiag' => $dataProviderDiag,
              'searchModelPAC' => $searchModelPAC ,
              'dataProviderPAC' => $dataProviderPAC ,
          ];
      return $searchModel;
    }

    public function validarSolicitud($model_paciente){
      //Si el paciente posee una solicitud sin internacion finalizada se restringira la creacion de una solicitud
      if ($model_paciente->solicitudvigente()){
        $this->setearMensajeError('El paciente ya posee una solicitud sin fecha de egreso');
        return false;
      }
      return true;
    }

    /**
     * Creates a new Solicitud model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_paciente) {
        $request = Yii::$app->request;
        $model = new SolicitudForm();
        $model->solicitud = new Solicitud;
        $model->solicitud->loadDefaultValues();
        //llama a todos los atributos set del modelo
        $model->setAttributes(Yii::$app->request->post());

        $request = Yii::$app->request;
        $model_paciente= Paciente::findOne($id_paciente);
        $modelosDat = $this->devolverModelos();
        if (Yii::$app->request->post() ) {
            if((isset($_POST['SolicitudDiagnosticos']) && !$this->validarPrincipal($_POST['SolicitudDiagnosticos'])) || !$this->validarSolicitud($model_paciente)){
              return $this->render('_form', ['model' => $model->solicitud,
              'model_paciente'=> $model_paciente,
              'modelosDat'=> $modelosDat,
            ]);
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->solicitud->id]);
        }
        else {
            return $this->render('_form', ['model' => $model->solicitud,
            'model_paciente'=> $model_paciente,
            'modelosDat'=> $modelosDat,
        ]);
          }

    }


    /**
     * Updates an existing Solicitud model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = new SolicitudForm();
        $model->solicitud = $this->findModel($id);

        //llama a todos los atributos set del modelo
        $model->setAttributes(Yii::$app->request->post());
        if (Yii::$app->user->identity->id_pantalla == 1) { //Principal
            $this->layout = 'main3';
        }
        $modelosDat = $this->devolverModelos();
        if (Yii::$app->request->post() ) {
          if(isset($_POST['SolicitudDiagnosticos']) && !$this->validarPrincipal($_POST['SolicitudDiagnosticos'])) {
            return $this->render('_form', ['model' => $model->solicitud,
            'model_paciente'=>$model->solicitud->paciente,
            'modelosDat'=> $modelosDat,]);
          }
          if ($model->solicitud->load($request->post()) && $model->solicitud->save()) {

            $model->save();
            return $this->redirect(['view', 'id' => $model->solicitud->id]);
          }
          else {
              return $this->render('_form', ['model' => $model->solicitud,
              'model_paciente'=>$model->solicitud->paciente,
              'modelosDat'=> $modelosDat,
               ]);
          }
        }
        else {
            return $this->render('_form', ['model' => $model->solicitud,
            'model_paciente'=>$model->solicitud->paciente,
            'modelosDat'=> $modelosDat,
             ]);
        }

    }




    /**
     * Finds the Solicitud model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Solicitud the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Solicitud::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    public function actionDelete($id) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($id);
        $request = Yii::$app->request;
        if ($request->isAjax) {
            try {
                  if (empty($model->reunionfamiliars) && empty($model->internacion)) {
                      // Eliminar registros relacionados
                       foreach ($model->solicitudDiagnosticos as $solicitudDiagnostico) {
                           $solicitudDiagnostico->delete();
                       }
                      if ($model->delete()) {
                        $this->setearMensajeExito('El registro se eliminó correctamente.');
                        return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax', 'metodo' => 'delete'];
                      }
                  }else {
                      $this->setearMensajeError('La solicitud tiene reuniones familiares o internaciones asociadas.');
                      return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax', 'metodo' => 'delete'];
                  }
              }
              catch(yii\db\Exception $e) {
                Yii::$app->response->format = Response::FORMAT_HTML;
                throw new NotFoundHttpException('Error en la base de datos. La solicitud esta asociada a un estudio', 500);
            }

          }
        else {
            // el metodo es invocado desde la clase hija,
            // pero quiero se redireccione a la clase controller del padre
            return $this->redirect(['solicitud/index']);
        }
    }


}
