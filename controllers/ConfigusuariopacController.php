<?php

namespace app\controllers;

use Yii;
use app\models\Configusuariopac;
use app\models\ConfigusuariopacSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\components\Metodos\Metodos;
use yii\filters\AccessControl;
/**
 * ConfiguusuariopacController implements the CRUD actions for ConfiguracionAniosUsuario model.
 */
class ConfigusuariopacController extends Controller
{

  public function actionPacienteselect($modelo) {
      $request = Yii::$app->request;
      if ($request->isAjax) {
          Yii::$app->response->format = Response::FORMAT_JSON;

          if (isset($_POST['seleccion'])) {
            // recibo datos de lo seleccionado, reconstruyo columnas
            // $selecciones = $_POST['seleccion'];
            // Configusuariopac::deleteAll(["id_usuario"=> Yii::$app->user->id]);
            //     $modelConf= new Configusuariopac();
            //     $modelConf->id_usuario= Yii::$app->user->id;
            //     $modelConf->pacinternados=($selecciones[0]=='pacinternados' )?true:false;
            //     $modelConf->pacsininternacion=($selecciones[1]=='pacsininternacion')?true:false;
            //     $modelConf->pacalta=($selecciones[2]=='pacalta')?true:false;
            //
            //     $modelConf->save();
            $seleccionados = Yii::$app->request->post('seleccion', []);
            $configuracion = [
                'pacsininternacion' => false,
                'pacinternados' => false,
                'pacalta' => false,
            ];

            // Actualizar los valores de acuerdo a lo que se haya recibido
            foreach ($seleccionados as $valor) {
                if (array_key_exists($valor, $configuracion)) {
                    $configuracion[$valor] = true;
                }
            }
            $id_usuario=Yii::$app->user->id;

            // Guardar la configuración en la base de datos
            $model = Configusuariopac::findOne(['id_usuario' => $id_usuario]);

            if (!$model) {
                // Si no existe, crear un nuevo registro
                $model = new Configusuariopac();
                $model->id_usuario = $id_usuario;
            }
            // Actualizar los campos en la base de datos
            $model->pacsininternacion = $configuracion['pacsininternacion'];
            $model->pacinternados = $configuracion['pacinternados'];
            $model->pacalta = $configuracion['pacalta'];
            $model->save();
            return [$model, 'forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        }else {
          // Obtener los años seleccionados por el usuario
            $id_usuario = Yii::$app->user->id;
            $seleccion = Configusuariopac::getSeleccion($id_usuario);
            $seleccionados = [];
            if ($seleccion) {
                foreach ($seleccion as $key => $value) {
                    if ($value) {
                        $seleccionados[] = $key;
                    }
                }
            }
                return ['success' => true,
                'message' => 'Configuración de años guardada correctamente.',
                 'title' => "Configuración personalizada",
                 'content' => $this->renderAjax('/../components/Vistas/_pacienteselect',
                  ['seleccionados'=>$seleccionados]) ,
                 'footer' => Html::button('Cancelar',
                 ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
                 . Html::button('Guardar', ['class' => 'btn btn-primary',
                 'type' => "submit"]) ];
        }
      } else {
          $this->redirect("index");
      }
  }



}
