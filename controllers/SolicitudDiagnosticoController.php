<?php

namespace app\controllers;

use Yii;
use app\models\SolicitudDiagnostico;
use app\models\SolicitudDiagnosticoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\Solicitud;
use app\models\DiagnosticoSearch;



/**
 * SolicitudDiagnosticoController implements the CRUD actions for SolicitudDiagnostico model.
 */
class SolicitudDiagnosticoController extends Controller{
  // behaviors heredado class CONTOLLER (accesos seguridad)

    /**
     * Lists all SolicitudDiagnostico models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SolicitudDiagnosticoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, null);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single SolicitudDiagnostico model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "SolicitudDiagnostico #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    public function devolverModelos(){

    ////////////DIAGNOSTICO/////////////////
      $searchModelDiag = new DiagnosticoSearch();
      $dataProviderDiag = $searchModelDiag->search(Yii::$app->request->queryParams,false);
      $dataProviderDiag->pagination->pageSize = 7;
      $searchModel=[
              'searchModelDiag' => $searchModelDiag,
              'dataProviderDiag' => $dataProviderDiag,
          ];
      return $searchModel;
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

    /**
     * Creates a new SolicitudDiagnostico model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_solicitud, $id_internacion)

    {
      if($id_internacion==0){
        $this->setearMensajeError('Debe registrar el ingreso de la internación.');
        return $this->redirect(['evolucionindicacion/index', 'id_solicitud' => $id_solicitud]);
      }

        $request = Yii::$app->request;
        $model = new SolicitudDiagnostico();
        $model_solicitud=  Solicitud::findOne(['id'=>$id_solicitud]);
        $modelosDat = $this->devolverModelos();
        if (isset($_POST['SolicitudDiagnostico']) && !$this->validarPrincipal($_POST['SolicitudDiagnostico'])) {
            return $this->render('_form', [
                'model' => $model,
                'model_solicitud'=>$model_solicitud,
                'modelosDat' => $modelosDat,
            ]);
        }
        // var_dump( $request->post());
        // die();

           if ($model->load($request->post())) {
             $requestData = Yii::$app->request->post('SolicitudDiagnostico');
             // Verificar si se recibieron datos válidos
             unset($requestData['__id__']); // Elimina el producto vacío usado para crear formularios

             if (!empty($requestData)) {
                 foreach ($requestData as $key => $data) {
                     // Verificar si el registro ya existe o si se debe crear uno nuevo
                     $solicitudDiagnostico = $key && strpos($key, 'nuevo') === false ? SolicitudDiagnostico::findOne($key) : false;

                     if ($solicitudDiagnostico) {
                         // Si el registro ya existe, usar el modelo existente
                         $model = $solicitudDiagnostico;
                     } else {
                         // Si el registro no existe, crear un nuevo modelo
                         $model = new SolicitudDiagnostico();
                     }

                     // Asignar los datos al modelo
                     $model->attributes = $data;

                     // Si necesitas ajustar o procesar algún dato antes de guardar, hazlo aquí

                     // Guardar el modelo y verificar si hay errores
                     if (!$model->save()) {
                         // Registrar los errores específicos
                         Yii::error("Error al guardar el registro $key: " . json_encode($model->errors));
                         // Puedes usar Yii::$app->session->setFlash para mostrar mensajes en la vista si es necesario
                         Yii::$app->session->setFlash('error', "Error al guardar el registro $key: " . json_encode($model->errors));
                         throw new \Exception('Error al guardar el registro.');
                     }
                     $this->setearMensajeExito('El registro se creo/actualizo correctamente.');

                 }
             }


                return $this->redirect(['evolucionindicacion/index', 'id_solicitud' => $id_solicitud]);
            } else {
                return $this->render('_form', [
                    'model' => $model,
                    'model_solicitud'=>$model_solicitud,
                    'modelosDat'=> $modelosDat,
                ]);
            }

    }

    /**
     * Updates an existing SolicitudDiagnostico model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update SolicitudDiagnostico #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "SolicitudDiagnostico #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                 return [
                    'title'=> "Update SolicitudDiagnostico #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing SolicitudDiagnostico model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $model = SolicitudDiagnostico::findOne($id);
        $id_solicitud=$model->id_solicitud;
         if ($model !== null) {
             if ($model->delete()) {
               $this->setearMensajeExito('El registro se eliminó correctamente.');
                 // Redireccionar a la vista de EvoluciónIndicación
                 $this->redirect(['evolucionindicacion/index' ,'id_solicitud'=>$id_solicitud]);
             } else {
                 // Manejar el error de eliminación
                 throw new Exception('Error al eliminar el registro.');
             }
         } else {
             // Manejar el error de registro no encontrado
             throw new NotFoundHttpException('El registro solicitado no se encontró.');
         }

    }



    /**
     * Finds the SolicitudDiagnostico model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SolicitudDiagnostico the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SolicitudDiagnostico::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
