<?php

namespace app\controllers;

use Yii;
use app\models\Reunionfamiliar;
use app\models\Solicitud;
use app\models\ReunionfamiliarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\PlantillareunionfamiliarSearch;
/**
 * ReunionfamiliarController implements the CRUD actions for Reunionfamiliar model.
 */
class ReunionfamiliarController extends Controller {
  // behaviors heredado class CONTOLLER (accesos seguridad)


    /**
     * Lists all Reunionfamiliar models.
     * @return mixed
     */
    public function actionIndex($id_solicitud)
    {
        $searchModel = new ReunionfamiliarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id_solicitud);
        $model_solicitud=  Solicitud::findOne(['id'=>$id_solicitud]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model_solicitud' =>$model_solicitud,
        ]);
    }

    /**
     * Displays a single Reunionfamiliar model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Reunion familiar #".$id. Html::a('<i class="fa fa-file-pdf-o "style="color:white;">  Exportar pdf</i>', ['reunionfamiliar/documento', 'id' => $id], [
                        'class' => 'btn btn-danger pull-right', // btn-danger para hacer todo el botón rojo
                        'title' => 'Archivo pdf',
                        'target' => '_blank',
                        'data-pjax' => '0'
                    ]) ,
                    'closeButton' => false,

                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Reunionfamiliar model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_solicitud)
    {
        $request = Yii::$app->request;
        $model = new Reunionfamiliar();
        $searchPRF = new PlantillareunionfamiliarSearch();
        $dataProviderPRF = $searchPRF->search(Yii::$app->request->queryParams);
        $dataProviderPRF->pagination->pageSize = 7;
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Crear nueva reunion familiar",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'id_solicitud' => $id_solicitud,
                        'search' => $searchPRF,
                        'provider' => $dataProviderPRF,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Crear nueva reunión familiar",
                    'content'=>'<span class="text-success">Exito al crear reunión familiar</span>',
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Crear más',['create', 'id_solicitud'=>$id_solicitud],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];
            }else{
                return [
                    'title'=> "Crear nueva reunión familiar",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'id_solicitud' => $id_solicitud,
                        'search' => $searchPRF,
                        'provider' => $dataProviderPRF,

                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'id_solicitud' => $id_solicitud,
                    'search' => $searchPRF,
                    'provider' => $dataProviderPRF,

                ]);
            }
        }

    }

    /**
     * Updates an existing Reunionfamiliar model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $searchPRF = new PlantillareunionfamiliarSearch();
        $dataProviderPRF = $searchPRF->search(Yii::$app->request->queryParams);
        $dataProviderPRF->pagination->pageSize = 7;
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Actualizar reunion familiar #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'id_solicitud' => $model->id_solicitud,
                        'search' => $searchPRF,
                        'provider' => $dataProviderPRF,

                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Reunionfamiliar #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'id_solicitud' => $model->id_solicitud
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Editar',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                 return [
                    'title'=> "Actualizar reunion familiar #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'id_solicitud' => $model->id_solicitud,
                        'search' => $searchPRF,
                        'provider' => $dataProviderPRF,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
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
                    'id_solicitud' => $model->id_solicitud,
                    'search' => $searchPRF,
                    'provider' => $dataProviderPRF,
                ]);
            }
        }
    }
    public function actionDocumento($id) {
        $request = Yii::$app->request;
        // Si entra en el if es porque el estudio esta en estado EN_PROCESO
        //Ver el view de biopsia donde se accde al informe
        if ($request->isAjax) {
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            return ['forceReload' => '#crud-datatable-pjax', 'title' => "AVISO!", 'content' => 'EL SIGUIENTE DOCUMENTO TIENE UN ESTADO <b>EN PROCESO</b> (NO ESTA TERMINADO) CONFIRME SI DESEA GENERAR EL DOCUMENTO', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> Confirmar', ['/biopsia/informe', 'id' => $id], ['class' => 'btn btn-primary', 'data-toggle' => 'tooltip', 'target' => '_blank', 'title' => 'Se abrirá el archivo PDF generado en una nueva ventana']) ];
        }
        else {
            $solicitud = $this->findModel($id);
            return $this->render('documento', ['model' => $solicitud ]);
        }
    }

    //delete hereda de Controller


    /**
     * Finds the Reunionfamiliar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reunionfamiliar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reunionfamiliar::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
