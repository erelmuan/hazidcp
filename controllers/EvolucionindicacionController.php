<?php

namespace app\controllers;

use Yii;
use app\models\Evolucionindicacion;
use app\models\EvolucionindicacionSearch;
use app\models\Solicitud;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\SolicitudDiagnosticoSearch;

/**
 * EvolucionindicacionController implements the CRUD actions for Evolucionindicacion model.
 */
class EvolucionindicacionController extends Controller{
  // behaviors heredado class CONTOLLER (accesos seguridad)

    public function devolverModelos($id_solicitud){

      $searchModel = new EvolucionindicacionSearch();
      // EVOLUCIONES ENFERMERIA //
      $dataProviderEnfermeria = $searchModel->search(Yii::$app->request->queryParams ,1,$id_solicitud);
      $dataProviderEnfermeria ->pagination->pageSize = 7;
      //EVOLUCIONES LOS DEMAS PROFRESIONALES//
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams,0,$id_solicitud);
      $dataProvider ->pagination->pageSize = 7;
      //Provider dianostico
      $searchModelDiagnostico = new SolicitudDiagnosticoSearch();
      $dataProviderdiagnostico = $searchModelDiagnostico->search(Yii::$app->request->queryParams ,$id_solicitud);
      $searchModel=[
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,
              'dataProviderEnfermeria' => $dataProviderEnfermeria ,
              'searchModelDiagnostico'=> $searchModelDiagnostico,
              'dataProviderdiagnostico' => $dataProviderdiagnostico,

          ];
      return $searchModel;
    }
    /**
     * Lists all Evolucionindicacion models.
     * @return mixed
     */
    public function actionIndex($id_solicitud)
    {

        $model_solicitud=  Solicitud::findOne(['id'=>$id_solicitud]);
        $modelosDat = $this->devolverModelos($id_solicitud);
        // Bandera para determinar si el usuario tiene la especialidad requerida
        $profesiones=NULL;
        $tieneEspecialidadEnfermeria = false;
        $this->profesionEspecialidad($profesiones,$tieneEspecialidadEnfermeria);
        return $this->render('index', [
            'model_solicitud' =>$model_solicitud,
            'modelosDat'=> $modelosDat,
            'tieneEspecialidadEnfermeria'=>$tieneEspecialidadEnfermeria

        ]);
    }


    /**
     * Displays a single Evolucionindicacion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Evolucionindicacion #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    public function profesionEspecialidad(&$profesiones,&$tieneEspecialidadEnfermeria){
      // Obtener todas las profesiones del usuario
      $profesiones = Yii::$app->user->identity->profesionals;
      // Iterar sobre las profesiones del usuario para verificar las especialidades
      foreach ($profesiones as $profesion) {
          if ($profesion->especialidad->nombre === 'ENFERMERIA') {
              $tieneEspecialidadEnfermeria = true;
              break;
          }
      }
    }

    public function validarEspecialidad($enfermeria, $id_solicitud)
    {
        $profesiones=NULL;
        // Bandera para determinar si el usuario tiene la especialidad requerida
        $tieneEspecialidadEnfermeria = false;
        $this->profesionEspecialidad($profesiones,$tieneEspecialidadEnfermeria);

        if (!$profesiones) {
            $this->setearMensajeError('Su usuario no esta asociado a ningún profesional.');
            Yii::$app->response->redirect(['evolucionindicacion/index', 'id_solicitud' => $id_solicitud])->send();
            Yii::$app->end();
        }
        // Validar según el parámetro enfermeria
        if ($enfermeria) {
            if (!$tieneEspecialidadEnfermeria) {
                $this->setearMensajeError('Su usuario debe tener la especialidad enfermería.');
                Yii::$app->response->redirect(['evolucionindicacion/index', 'id_solicitud' => $id_solicitud])->send();
                Yii::$app->end();
            }
        } else {
            if ($tieneEspecialidadEnfermeria) {
                $this->setearMensajeError('Su usuario debe poseer una especialidad distinta a enfermería.');
                Yii::$app->response->redirect(['evolucionindicacion/index', 'id_solicitud' => $id_solicitud])->send();
                Yii::$app->end();
            }
        }

    }

    /**
     * Creates a new Evolucionindicacion model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate($id_internacion, $enfermeria, $id_solicitud)
   {
       // Verificar si la internación está registrada
       if ($id_internacion == 0) {
           $this->setearMensajeError('Debe registrar el ingreso de la internación.');
           return $this->redirect(['index', 'id_solicitud' => $id_solicitud]);
       }

       // Validar la especialidad antes de continuar
       $this->validarEspecialidad($enfermeria, $id_solicitud);

       $request = Yii::$app->request;
       $model = new Evolucionindicacion();
       $model_solicitud = Solicitud::findOne(['id' => $id_solicitud]);

       // Intentar cargar y guardar el modelo
       if ($model->load($request->post()) && $model->save()) {
         $this->setearMensajeExito('El registro se creó correctamente.');
           return $this->redirect(['index', 'id_solicitud' => $id_solicitud]);
       } else {
           $createView= $enfermeria ? '_form-enfermeria' : '_form';
           return $this->render($createView, [
               'model' => $model,
               'id_internacion' => $id_internacion,
               'model_solicitud' => $model_solicitud,
           ]);
       }
   }


    /**
     * Updates an existing Evolucionindicacion model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id ,$enfermeria)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $this->validarEspecialidad($enfermeria, $model->internacion->solicitud->id);

            if ($model->load($request->post()) && $model->save()) {
              $this->setearMensajeExito('El registro se actualizó correctamente.');
                return $this->redirect(['index', 'id_solicitud' => $model->internacion->solicitud->id]);
            } else {
              $updateView = $enfermeria ? '_form-enfermeria' : '_form';
                return $this->render($updateView, [
                    'model' => $model,
                    'id_internacion' => $model->id_internacion,
                    'model_solicitud'=>$model->internacion->solicitud
                ]);
            }

    }

//HEREDA DE CONTROLLER


    /**
     * Finds the Evolucionindicacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Evolucionindicacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Evolucionindicacion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
