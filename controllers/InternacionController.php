<?php

namespace app\controllers;

use Yii;
use app\models\Internacion;
use app\models\InternacionSearch;
use app\models\Detalle;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * InternacionController implements the CRUD actions for Internacion model.
 */
class InternacionController extends Controller{
  // behaviors heredado class CONTOLLER (accesos seguridad)


    /**
     * Lists all Internacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InternacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Internacion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Internacion #".$id,
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
     * Creates a new Internacion model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_solicitud=NULL)
    {
        $request = Yii::$app->request;
        $model = new Internacion();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Crear nueva internacion",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'id_solicitud'=>$id_solicitud,

                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->save()){
              $this->setearMensajeExito('El registro se creó correctamente.');
                return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax', 'metodo' => 'action'];
            }else{
                return [
                    'title'=> "Crear nueva internacion",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'id_solicitud'=>$id_solicitud,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }

    }

    /**
     * Updates an existing Internacion model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id , $tipo)
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
                    'title'=> "Actualizar Internacion #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'tipo'=> $tipo,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
              $this->setearMensajeExito('El registro se actualizó correctamente.');

              return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax', 'metodo' => 'action'];

            }else{
                 return [
                    'title'=> "Actualizar Internacion #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'tipo'=> $tipo,
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Guardar',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }
    }

    /**
     * Delete an existing Internacion model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }
    public function actionSubcat() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $id_tipoegreso = $parents[0];
                //obtener todas las localidades por el id de la organismo
                $Arraydetalles = Detalle::findall(['id_tipoegreso' => $id_tipoegreso]);
                ArrayHelper::multisort($Arrayareas, ['descripcion'], [SORT_ASC]);
                $i = 0;
                $detalles = [];
                foreach ($Arraydetalles as $key => $value) {
                    $detalles[$i] = array(
                        'id' => $value['id'],
                        'name' => $value['descripcion']
                    );
                    $i = $i + 1;
                }
                $out = [['id' => '<sub-cat-id-1>', 'name' => '<sub-cat-name1>'], ['id' => '<sub-cat_id_2>', 'name' => '<sub-cat-name2>']];
                return Json::encode(['output' => $detalles]);
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    /**
     * Finds the Internacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Internacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Internacion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
