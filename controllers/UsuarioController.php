<?php
namespace app\controllers;
use Yii;
use Yii\helpers\ArrayHelper;
use app\models\Auditoria;
use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\RolSearch;
use app\models\Rol;
use app\components\Metodos\Metodos;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\imagine\Image;
use app\models\Tema;
use app\models\Menu;
use app\models\Configuracion;
use app\models\Provincia;
use app\models\Localidad;
use app\models\User;
use app\models\Profesional;
/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller {
  // behaviors heredado class CONTOLLER (accesos seguridad)

    /**
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $request = Yii::$app->request;
        if ($request->isAjax) { // modal para cambiar contraseña
            Yii::$app->response->format = Response::FORMAT_JSON;

            if (!User::isUserAdmin()) {
                return ['title' => "Cambiar contraseña #", 'content' => "No puede cambiar una contraseña si no es administrador", 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
            }
            $model = $this->findModel($_GET['id']);
            if ($dato = $request->post()) {
                $model->pass_new = $dato['Usuario']['pass_new'];
                try {
                    // cambiar solo contraseña
                    $model->contrasenia = md5($model->pass_new);
                    if ($model->save()) {
                        $content = '<span class="text-success">Contraseña cambiada correctamente</span>';
                        return ['title' => "Cambiar Contraseña", 'content' => $content, ];
                    }
                    else {
                        $content = '<span class="text-success">Recuerde que tiene que estar activo</span>';
                        return ['title' => "Cambiar Contraseña", 'content' => $content, ];
                    }
                }
                catch(yii\db\Exception $e) {
                    Yii::$app
                        ->response->format = Response::FORMAT_HTML;
                    throw new NotFoundHttpException('Error en la base de datos.', 500);
                }
            }
            return ['title' => "Resetear Contraseña", 'content' => $this->renderAjax('_contraseniaReset', ['model' => $model, ]) , 'footer' => Html::button('Cancelar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
        }
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, ]);
    }
    /**
     * Displays a single Usuario model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['title' => "Usuario #" . $id,
            'content' => $this->renderAjax('view', ['model' => $this->findModel($id) , ]) ,
             'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left',
             'data-dismiss' => "modal"]) ];
        }
        else {
            return $this->render('view', ['model' => $this->findModel($id) , ]);
        }
    }

    public function crearConfiguracion(){
        $configuracion= new Configuracion();
        $configuracion->loadDefaultValues();
        $configuracion->save();
        return $configuracion;
    }
    /**
     * Creates a new Usuario model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $request = Yii::$app->request;
        $model = new Usuario();
        $provincias = [];
        $localidades = [];
        $this->devolverArray($model,$provincias, $localidades);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return ['title' => "Crear nuevo Usuario", 'content' => $this->renderAjax('create', ['model' => $model,'provincias'=> $provincias,'localidades'=> $localidades ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
            else if ($model->load($request->post()) ) {
                  $configuracion=$this->crearConfiguracion();
                  $model->id_configuracion= $configuracion->id;
                if($model->save())
                  return [
                    'forceReload' => '#crud-datatable-pjax',
                  'title' => "Crear nuevo Usuario", 'content' => '<span class="text-success">Usuario creado satisfactoriamente</span>', 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('Crear más', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
            }
            else {
                return ['title' => "Crear nuevo Usuario", 'content' => $this->renderAjax('create', ['model' => $model, ]) , 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];

            }
        }
        else {

            if ($model->load($request->post())) {
              $configuracion=$this->crearConfiguracion();
              $model->id_configuracion= $configuracion->id;
              if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else {
                return $this->render('create', ['model' => $model,'provincias'=> $provincias,'localidades'=> $localidades ]);
            }
        }
    }
    public function devolverArray($model,&$provincias, &$localidades){

      $provincias = ArrayHelper::map(Provincia::find()->all() , 'id', 'nombre');
      $Arraylocalidades = LocalidadController::findidproModel($model->id_provincia);
      foreach ($Arraylocalidades as $key => $value) {
          $localidades[$value['id']] = $value['nombre'];
      }
    }
    /**
     * Updates an existing Usuario model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $provincias = [];
        $localidades = [];
        $this->devolverArray($model,$provincias, $localidades);
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (!User::isUserAdmin()) {
                return ['title' => "Cambiar contraseña #", 'content' => "No puede editar si no es administrador", 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
            }
            if ($request->isGet) {
                return ['title' => "Actualizar Usuario #" . $id,
                'content' => $this->renderAjax('update',
                ['model' => $model, 'provincias'=> $provincias,'localidades'=> $localidades ]) ,
                'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left',
                 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary'
                 , 'type' => "submit"]) ];
            }
            else if ($model->load($request->post()) && $model->save()) {
                return [
                'forceReload' => '#crud-datatable-pjax',
                'title' => "Usuario #" . $id,
                'content' => $this->renderAjax('view', ['model' => $model,'provincias' => $provincias, 'localidades' =>
                 $localidades,]) ,
                 'footer' => Html::button('Cerrar',
                 ['class' => 'btn btn-default pull-left',
                  'data-dismiss' => "modal"]) .
                   Html::a('Editar', ['update', 'id' => $id],
                    ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
            }
            else {
                return ['title' => "Actualizar Usuario #" .
                $id, 'content' => $this->renderAjax('update', ['model' => $model, 'provincias'=> $provincias,'localidades'=> $localidades ]) ,
                'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
        }
        else {
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else {

                return $this->render('update', ['model' => $model, 'provincias'=> $provincias,'localidades'=> $localidades]);
            }
        }
    }
    /**
     * Delete an existing Usuario model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
      Yii::$app->response->format = Response::FORMAT_JSON;
      $request = Yii::$app->request;
        if (Yii::$app->user->identity->id == $id) {
            $this->setearMensajeError('No puede eliminarse a si mismo');
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax','metodo'=>'delete'];
        }
        if (!User::isUserAdmin()) {
            $this->setearMensajeError('No puede eliminar usuario si no es administrador');
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax','metodo'=>'delete'];
        }
        if (profesional::find()->where(['id_usuario'=>$id])->count()>0 ){
          $this->setearMensajeError('No se puede eliminar el usuario porque esta asociado a uno o más profesionales');
          return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax','metodo'=>'delete'];
        }
        if (Auditoria::find()->where(['id_usuario'=>$id])->count()>0 ){
          $this->setearMensajeError('No se puede eliminar el usuario porque esta asociado a una o más auditorias');
          return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax','metodo'=>'delete'];
        }
        if ($request->isAjax) {
          $this->findModel($id)->delete();
          $this->setearMensajeExito('El registro se eliminó correctamente');
          return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax','metodo'=>'delete'];
        }
        else {
            return $this->redirect(['index']);
        }
    }

    public function actionListdetalle() {
        if (isset($_POST['expandRowKey'])) {
            $searchModel = new UsuarioSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andWhere(['id' => $_POST['expandRowKey']])
            ->andWhere(['not', ['id_rol' => null]]);
            $dataProvider->setPagination(false);
            $dataProvider->setSort(false);
            return $this->renderPartial('_listDetalle', ['id_maestro' => $_POST['expandRowKey'],
             'searchModel' => $searchModel, 'dataProvider' => $dataProvider, ]);
        }
        else {
            return '<div>No se encontraron resultados</div>';
        }
    }
    public function actionAddrol() {
        if (!Yii::$app->request->isAjax){
          return $this->redirect(["index"]);
        }

        if (isset($_POST['keylist']) and isset($_POST['id_usuario'])) {
            $lerror = false;
            $id_usuario = $_POST['id_usuario'];
              $modelUsuario = $this->findModel($id_usuario);
              $modelUsuario->id_rol = $_POST['keylist'] ;
                if (!$modelUsuario->save()) {
                    $lerror = true;
                    }
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            if ($lerror) {
                return ['status' => 'error'];
            }
            return ['status' => 'success'];
            Yii::$app->end();
        }
        $modelDetalle = new Rol();
        $searchModel = new RolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $columnas = Metodos::obtenerColumnas($modelDetalle);

        Yii::$app
            ->response->format = Response::FORMAT_JSON;
        return ['title' => 'Agregar Rol', 'content' =>
        $this->renderAjax('_addrol', ['searchModel' => $searchModel,
        'dataProvider' => $dataProvider, 'columns' => $columnas,
        'id_usuario' => $_GET['id_maestro'], ]) , ];


    }
    public function actionDeletedetalle($id_detalle) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->user->identity->id == $id_detalle) {
          $this->setearMensajeError('No puede eliminarse el rol usted mismo');
          return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        }

        if (!User::isUserAdmin()) {
            return ['title' => "Eliminar Rol #" . $id, 'content' => "No puede eliminar un rol si no es administrador", 'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) ];
        }
        try {
            if ($modelUsuario = Usuario::findOne($id_detalle)) {
                // borro registro en este caso por que es una relacion NN
                 $modelUsuario->id_rol=null;
                 if($modelUsuario->save()){
                   return ['forceClose' => true, 'success' => 'reloadDetalle(' . $id_detalle . ')'];
                 }else {
                   return ['status'=>'error'];
                    Yii::$app->end();
                 }
            }
        }
        catch(yii\db\Exception $e) {
            return ['forceClose' => false, 'title' => '<p style="color:red">ERROR</p>', 'content' => '<div style=" font-size: 14px">Errores en la operacion indicada. Verifique.</div>', 'success' => 'reloadDetalle(' . $id_maestro . ')'];
        }
    }
    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionCambiarcontrasenia(){
      $request = Yii::$app->request;
      $id = Yii::$app->user->identity->getId();
      $model = $this->findModel($id);
      if ($request->isAjax) { // modal para cambiar contraseña
          Yii::$app->response->format = Response::FORMAT_JSON;
          if ($dato = $request->post()) {
              $model->pass_ctrl = $dato['Usuario']['pass_ctrl'];
              $model->pass_new = $dato['Usuario']['pass_new'];
              $model->pass_new_check = $dato['Usuario']['pass_new_check'];
              if ($model->pass_new <> $model->pass_new_check) {
                  $model->addError('pass_new', 'La contraseña ingresada no coincide.');
                  $model->addError('pass_new_check', 'La contraseña ingresada no coincide.');
              }
              else {
                  if (md5($model->pass_ctrl) <> $model->contrasenia) {
                      $model->addError('pass_ctrl', 'La contraseña ingresada no es correcta.');
                  }
                  else {
                      try {
                          // cambiar solo contraseña
                          $model->contrasenia = md5($model->pass_new);
                          if ($model->save()) {
                            $this->setearMensajeExito('Datos guardados correctamente');
                            return $this->redirect(['usuario/perfil']); // Redirigir a la misma página después de guardar con éxito

                          }
                      }
                      catch(yii\db\Exception $e) {
                          Yii::$app
                              ->response->format = Response::FORMAT_HTML;
                          throw new NotFoundHttpException('Error en la base de datos.', 500);
                      }
                  }
              }
          }
          return ['title' => "Cambiar Contraseña",
          'content' => $this->renderAjax('_contrasenia', ['model' => $model, ]) ,
          'footer' => Html::button('Cancelar',
           ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
           . Html::button('Guardar', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
      }
    }
      //Parametros pasados por referencia
      private function guadarImagen(&$model,&$image){
        $ext = explode(".", $image->name);
        $ext = end($ext);
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/avatar/';
        $nombreEncriptadoImagen = Yii::$app->security->generateRandomString() . ".{$ext}";
        $path = Yii::$app->params['uploadPath'] . $nombreEncriptadoImagen;
        $model->imagen = $nombreEncriptadoImagen;
        $image->saveAs($path);
        // Redimensionamiento de la imagen (opcional)
        Image::thumbnail(Yii::$app->params['uploadPath'] . $nombreEncriptadoImagen, 120, 120)
            ->save(Yii::$app->params['uploadPath'] . 'sqr_' . $nombreEncriptadoImagen, ['quality' => 100]);
        Image::thumbnail(Yii::$app->params['uploadPath'] . $nombreEncriptadoImagen, 30, 30)
            ->save(Yii::$app->params['uploadPath'] . 'sm_' . $nombreEncriptadoImagen, ['quality' => 100]);
      }

      public function actionPerfil() {
          $request = Yii::$app->request;
          $id = Yii::$app->user->identity->getId();
          $model = $this->findModel($id);
          $post = $request->post();
          if ($model->load($post)) {
              $image = UploadedFile::getInstance($model, 'imagen');
              // Manejar la subida de la imagen si está presente
              if (!is_null($image) && $image !== "") {
                  $this->guadarImagen($model, $image);
              }
              if ($model->save()) {
                $this->setearMensajeExito('Datos guardados correctamente');
                return $this->refresh(); // Redirigir a la misma página después de guardar con éxito
              }
          }
          return $this->render('perfil', ['model' => $model]);
      }



      public function actionConfiguracion() {
          $temas= ArrayHelper::map(Tema::find()->all(), 'id','descripcion');
          $menus= ArrayHelper::map(Menu::find()->all(), 'id','tipo');

          $request = Yii::$app->request;
          $id = Yii::$app->user->identity->getId();
          $model = $this->findModel($id);
          if ($model->configuracion->load($request->post())  && $model->configuracion->save()) {
            $this->setearMensajeExito('Datos guardados correctamente');
            return $this->goHome();
          }else {
            return $this->render('configuracion', ['model' => $model,  'temas'=>$temas , 'menus'=>$menus]);

          }

      }
}
