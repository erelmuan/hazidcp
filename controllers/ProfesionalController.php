<?php
namespace app\controllers;
use Yii;
use app\models\Solicitud;
use app\models\Profesional;
use app\models\ProfesionalSearch;
use app\models\PacienteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use app\models\Usuario;
use app\models\UsuarioSearch;
use app\models\PrestadorSearch;

/**
 * ProfesionalController implements the CRUD actions for Profesional model.
 */
class ProfesionalController extends Controller {
  // behaviors heredado class CONTOLLER (accesos seguridad)

    public function actionSearch() {
        $searchModelProf = new ProfesionalSearch();
        $searchModelProf->scenario = "search";
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $searchModelProf->load(\Yii::$app
                ->request
                ->get());
            if ($searchModelProf->validate()) {
                $dataProviderProf = $searchModelProf->search(\Yii::$app
                    ->request
                    ->get());
                if ($dataProviderProf->totalCount == 0) return Json::encode(['status' => 'error', 'mensaje' => "No se encontro el profesional"]);
                else return Json::encode(['nombre' => $dataProviderProf->getModels() [0]['nombre'], 'apellido' => $dataProviderProf->getModels() [0]['apellido'], 'id' => $dataProviderProf->getModels() [0]['id']]);
            }
            else {
                $errors = $searchModelProf->getErrors();
                return Json::encode(['status' => 'error', 'mensaje' => $errors['matricula'][0]]);
            }
        }
    }
    public function devolverModelos(){

      ////////////USUARIO/////////////////
      $searchModelUsu = new UsuarioSearch();
      $dataProviderUsu = $searchModelUsu->search(Yii::$app->request->queryParams);
      $dataProviderUsu->pagination->pageSize=7;
      ////////////DIAGNOSTICO/////////////////
      $searchModelPrest = new PrestadorSearch();
      $dataProviderPrest = $searchModelPrest->search(Yii::$app->request->queryParams,false);
      $dataProviderPrest->pagination->pageSize = 7;
      $searchModel=[
              'searchModelUsu' => $searchModelUsu ,
              'dataProviderUsu' => $dataProviderUsu ,
              'searchModelPrest' => $searchModelPrest,
              'dataProviderPrest' => $dataProviderPrest,
          ];
      return $searchModel;
    }
    /**
     * Lists all Profesional models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ProfesionalSearch();
        $dataProvider = $searchModel->search(Yii::$app
            ->request
            ->queryParams);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, ]);
    }
    /**
     * Displays a single Profesional model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            return ['title' => "Profesional #" . $id, 'content' => $this->renderAjax('_detalleview', ['model' => $this->findModel($id) , ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        else {
            return $this->render('view', ['model' => $this->findModel($id) , ]);
        }
    }
    /**
     * Creates a new Profesional model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new Profesional();

        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        else {
            $modelosDat = $this->devolverModelos();
            return $this->render('_form', [
              'model' => $model,
              'modelosDat' => $modelosDat,
           ]);
        }
    }
    /**
     * Updates an existing Profesional model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        else {
          $modelosDat = $this->devolverModelos();
          return $this->render('_form', [
            'model' => $model,
            'modelosDat' => $modelosDat,
         ]);
        }
    }
    
    //delete hereda de Controller


    /**
     * Finds the Profesional model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profesional the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Profesional::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
