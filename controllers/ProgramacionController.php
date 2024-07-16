<?php

namespace app\controllers;

use Yii;
use app\models\Programacion;
use app\models\ProgramacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * ProgramacionController implements the CRUD actions for Programacion model.
 */
class ProgramacionController extends Controller
{
  // behaviors heredado class CONTOLLER (accesos seguridad)


    // /**
    //  * Lists all Programacion models.
    //  * @return mixed
    //  */
    // public function actionIndex()
    // {
    //     $searchModel = new ProgramacionSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    //
    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }


      public function actionIndex(){
              $searchModel = new ProgramacionSearch();
              $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

              // $searchModel = new WiewQuirofanosDisponiblesSearch();
              // $dataProvider = $searchModel->search($this->request->queryParams);
              //   $parametrizacion= Parametrizacion::find()->one();
              //
              // $cirugias= Cirugiaprogramada::find()->select("fecha_cirugia")->distinct()
              // ->andWhere(["and","fecha_cirugia >= (current_date::date - interval '60 day') and id_estado !=2 and id_estado !=3 "])->all();
              // //NO TIENE QUE SER ANULADA ID 2 NI REPROGRAMADA ID REPROGRAMADA
              // $quirofanos= Quirofano::find()->all();
              $tasks = [];
            //   foreach ($cirugias as $cirugia) {
            //     foreach ($quirofanos as $quirofano) {
            //       $event= new \yii2fullcalendar\models\Event();
            //         $event->id= $quirofano->id;
            //         $fecha=date("Y-m-d", strtotime($cirugia->fecha_cirugia));
            //             $valor=$this->porcentaje($quirofano->id,$fecha);
            //             if(trim($valor)==='100'){
            //               $event->color= "red";
            //             }else {
            //               if ($valor>=$parametrizacion->niveles){
            //                 $event->color= '#d1b50b';
            //               }else {
            //                 $event->color= "green";
            //
            //               }
            //             }
            //
            //         $event->title= $quirofano->nombre." - ".$valor."%";
            //
            //         $event->start=$fecha;
            //         $event->url='index.php?r=cirugiaprogramada/fecha&dia='.$fecha;
            //         if ($valor!='0'){
            //             $tasks[]=$event;
            //         }
            //
            //     }
            // }
            //Entra si el quirofano tiene una cirugia programada
            // $dia_sin_cirugias=DiasSinCirugia::find()->
            // andWhere(["and","fecha >= (current_date::date - interval '60 day')"])->all();
            // foreach ($dia_sin_cirugias as $dia_sin_cirugia) {
            //     $event= new \yii2fullcalendar\models\Event();
            //     $event->title=$dia_sin_cirugia->motivo;
            //     $event->start=$dia_sin_cirugia->fecha;
            //     $event->color= "blue";
            //     $tasks[]=$event;
            // }
                  $dataProvider->pagination->pageSize=7;
             return $this->render('index', [
                'events' => $tasks,
                'searchModel'=>$searchModel,
                'dataProvider' =>$dataProvider
              ]);
            }

    /**
     * Displays a single Programacion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Programacion #".$id,
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

    /**
     * Creates a new Programacion model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Programacion();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new Programacion",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new Programacion",
                    'content'=>'<span class="text-success">Create Programacion success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];
            }else{
                return [
                    'title'=> "Create new Programacion",
                    'content'=>$this->renderAjax('create', [
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
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }

    /**
     * Updates an existing Programacion model.
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
                    'title'=> "Update Programacion #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Programacion #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                 return [
                    'title'=> "Update Programacion #".$id,
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
     * Delete an existing Programacion model.
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

     /**
     * Delete multiple existing Programacion model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

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

    /**
     * Finds the Programacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Programacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Programacion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
