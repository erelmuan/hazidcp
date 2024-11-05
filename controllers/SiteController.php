<?php
namespace app\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
//modelos
use app\models\Paciente;
use app\models\Solicitud;
use app\models\Profesional;
use app\models\Procedencia;
use app\models\Provincia;
use app\models\Localidad;
use app\models\Usuario;
use app\models\Auditoria;
use app\models\Rol;
use app\models\Modulo;
use app\models\Accion;
use app\models\Obrasocial;
use app\models\Nacionalidad;
use app\models\Tipodoc;
use app\models\Estado;
use app\models\Servicio;
use app\models\User;
use app\models\Registrosesion;
use app\models\Especialidad;
use app\models\Actividad;
use app\models\Prestador;
use app\models\Tipoacceso;
use app\models\Tipoactividad;
use app\models\Plantillareunionfamiliar;
use app\models\Detalle;

use app\models\Tipodom;
use app\models\Tipotel;
use app\models\Tipoegreso;
use app\models\Tipoingreso;
use app\models\Tipointernacion;
use app\models\Barrio;
use app\models\Empresa;
use app\models\Diagnostico;


use yii\web\Cookie;
use app\components\Seguridad\Seguridad;
class SiteController extends Controller {
    /**
     * {@inheritdoc}
     */
     public function behaviors() {
         return [
             'access' => [
                 'class' => AccessControl::className(),
                 'only' => ['logout', 'administracion', 'extras','permisos'],
                 'rules' => [
                     [
                         'actions' => ['logout'],
                         'allow' => true,
                         'roles' => ['@'],
                     ],
                     [
                         'actions' => ['logout', 'administracion', 'extras','permisos'],
                         'allow' => true,
                         'roles' => ['@'],
                         'matchCallback' => function ($rule, $action) {
                             // Aquí colocamos la lógica de verificación de permisos
                             return Seguridad::tienePermiso($action->id); // $action->id puede no ser necesario, depende de tu implementación
                         }
                     ],
                     [
                         'roles' => ['@'],
                         'matchCallback' => function ($rule, $action) {
                             if (Yii::$app->user->identity->id_pantalla == 1) {
                                 return false;
                             } else {
                                 return true;
                             }
                         }
                     ],
                 ],
             ],
             'verbs' => [
                 'class' => VerbFilter::className(),
                 'actions' => [
                     'logout' => ['post'],
                 ],
             ],
         ];
     }

    /**
     * {@inheritdoc}
     */


    public function actionError()
    {
      $this->layout = 'template_error';
      $controller = Yii::$app->requestedAction->controller->id;
      $action = Yii::$app->requestedAction->id;
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception , 'controller'=>$controller ,'action'=>$action]);
        }
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        if (Yii::$app->user->identity->id_pantalla == 1 && !User::isUserAdmin()){
          return $this->redirect(Yii::$app->request->baseUrl.'/solicitud/consulta');

        }
        $cantidadSolicitudes = Solicitud::find()->where(['<>', 'id_estado',4])->count();
        $cantidadPacientes = Paciente::find()->count();
        $cantidadProcedencia = Procedencia::find()->count();
        $cantidadProfesionales = Profesional::find()->count();
        $cantidadActividades = Actividad::find()->count();
        $cantidadPrestadores = Prestador::find()->count();

        return $this->render('index', [ 'cantidadSolicitudes' => $cantidadSolicitudes,
        'cantidadPacientes' => $cantidadPacientes,  'cantidadProcedencia' => $cantidadProcedencia,
        'cantidadProfesionales' => $cantidadProfesionales,'cantidadActividades' =>$cantidadActividades,
        'cantidadPrestadores' =>$cantidadPrestadores]);
    }

    public function registrarsesion(){
          // Obtener la información necesaria
       $idUsuario = Yii::$app->user->identity->id;
       $inicioSesion = date('Y-m-d H:i:s');
       $ip = Yii::$app->request->getUserIP();
       $informacionUsuario = Yii::$app->request->getUserAgent(); // Aquí debes proporcionar la información necesaria
       // Generar una cookie única para la sesión
       $cookieValue = uniqid('sesion_', true);
       $cookie = new Cookie([
           'name' => 'sesion',
           'value' => $cookieValue,
           'expire' => time() + 3600, // Tiempo de expiración de la cookie (en segundos)
       ]);
       Yii::$app->response->cookies->add($cookie);

       // Crear una nueva instancia del modelo Sesion
       $sesion = new Registrosesion();
       $sesion->id_usuario = $idUsuario;
       $sesion->iniciosesion = $inicioSesion;
       $sesion->ip = $ip;
       $sesion->informacionusuario = $informacionUsuario;
       $sesion->cookie = $cookieValue;

       // Guardar el registro de inicio de sesión en la base de datos
       $sesion->save();
    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        $this->layout = 'main2';
        if (!Yii::$app->user->isGuest) {
            /* Al entrar al sistema aparecera la pagina de login (return $this->render('login'),puesto
            que no entra a este if y tampoco al siguiente ( porque no esta logueado
            y por lo tanto  es invitado ni valida el post)*/
            /* Si se loguea entonces, pasa de largo la primera vez el isGuest
            entra al segundo if, se valida return goback hace volver al loguin
            de esa forma ahi si entra al primer if, y se dirige al pagina de inicio home() */
            /*Si vuelve para atras una vez logueado se redigira al primer if */
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (!Yii::$app->user->identity->activo) {
                Yii::$app->user->logout();
            }
            $this->registrarsesion ();
            return $this->goBack();
        }
        $model->password = '';
        return $this->render('login', ['model' => $model, ]);
    }


    public function registroLogout(){
      // Obtener la información necesaria
          $idUsuario = Yii::$app->user->identity->id;
          $cierreSesion = date('Y-m-d H:i:s');
          // Obtener el valor de la cookie de sesión actual
          $cookieValue = Yii::$app->request->cookies->getValue('sesion');
          // Buscar la sesión actual del usuario con la cookie correspondiente
          $registrarsesion = Registrosesion::find()
              ->where(['id_usuario' => $idUsuario])
              ->andWhere(['cookie' => $cookieValue])
              ->andWhere(['cierresesion' => null])
              ->orderBy(['iniciosesion' => SORT_DESC])
              ->one();
          if ($registrarsesion) {
              // Actualizar la fecha y hora de cierre de sesión
              $registrarsesion->cierresesion = $cierreSesion;
              $registrarsesion->save();
          }
    }
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        // Obtener la instancia de la sesión
        $session = Yii::$app->session;
        // Iniciar la sesión si no está iniciada aún
        if (!$session->isActive) {
            $session->open();
        }
        $usuario=Yii::$app->user->identity->usuario;
        //Registramos el cierre de sesion
        $this->registroLogout();
        //cerramos sesion
        Yii::$app->user->logout();
        // Almacenar un valor en la variable de sesión
        $session->set('mensajeDelSistema', 'adios');
        $session->set('usuario_salida',$usuario  );

        return $this->goHome();
    }
    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', ['model' => $model, ]);
    }
    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {
        return $this->render('about');
    }
    public function actionPlantillas() {
        $cantidadPlantillaDiag = Plantilladiagnostico::find()->count();
        $cantidadPlantillaMic = Plantillamicroscopia::find()->count();
        $cantidadPlantillaMac = Plantillamacroscopia::find()->count();
        $cantidadPlantillaMatb = Plantillamaterial::find()->count();
        $cantidadPlantillaFra = Plantillafrase::find()->count();
        return $this->render('plantillas', ['cantidadPlantillaDiag' => $cantidadPlantillaDiag, 'cantidadPlantillaMic' => $cantidadPlantillaMic, 'cantidadPlantillaMac' => $cantidadPlantillaMac, 'cantidadPlantillaMatb' => $cantidadPlantillaMatb, 'cantidadPlantillaFra' => $cantidadPlantillaFra, ]);
    }
    public function actionExtras() {
        $cantidadProcedencia = Procedencia::find()->count();
        $cantidadProvincia = Provincia::find()->count();
        $cantidadLocalidad = Localidad::find()->count();
        $cantidadEspecialidad = Especialidad::find()->count();
        $cantidadObrasocial = Obrasocial::find()->count();
        $cantidadNacionalidad = Nacionalidad::find()->count();
        $cantidadEspecialidad = Especialidad::find()->count();
        $cantidadTipoDoc = Tipodoc::find()->count();
        $cantidadEstado = Estado::find()->count();
        $cantidadDetalle = Detalle::find()->count();
        $cantidadServicios = Servicio::find()->count();
        $cantidadSolicitudesAnuladas = Solicitud::find()->where(['=','id_estado',4])->count();
        $cantidadTipoActividades = Tipoactividad::find()->count();
        $cantidadplantillareunionfamiliares = Plantillareunionfamiliar::find()->count();

        $cantidadTipoDomicilios = Tipodom::find()->count();
        $cantidadTipoTelefonos = Tipotel::find()->count();
        $cantidadTipoEgresos = Tipoegreso::find()->count();
        $cantidadTipoIngresos = Tipoingreso::find()->count();
        $cantidadTipoInternaciones = Tipointernacion::find()->count();

        $cantidadBarrios = Barrio::find()->count();
        $cantidadEmpresas = Empresa::find()->count();
        $cantidadDiagnosticos = Diagnostico::find()->count();



        return $this->render('extras', [
         'cantidadProcedencia' => $cantidadProcedencia,
         'cantidadProvincia' => $cantidadProvincia,
         'cantidadLocalidad' => $cantidadLocalidad,
         'cantidadEspecialidad' => $cantidadEspecialidad,
         'cantidadObrasocial' => $cantidadObrasocial,
         'cantidadNacionalidad' => $cantidadNacionalidad,
         'cantidadTipoDoc' => $cantidadTipoDoc,
         'cantidadEstado' => $cantidadEstado,
         'cantidadServicios' =>$cantidadServicios,
         'cantidadSolicitudesAnuladas' =>$cantidadSolicitudesAnuladas,
         'cantidadTipoActividades' => $cantidadTipoActividades,
         'cantidadplantillareunionfamiliares' =>$cantidadplantillareunionfamiliares,
         'cantidadTipoDomicilios' =>$cantidadTipoDomicilios,
         'cantidadTipoTelefonos' =>$cantidadTipoTelefonos,
         'cantidadTipoEgresos' =>$cantidadTipoEgresos,
         'cantidadTipoIngresos' =>$cantidadTipoIngresos,
         'cantidadTipoInternaciones' =>$cantidadTipoInternaciones,
         'cantidadBarrios' => $cantidadBarrios,
         'cantidadEmpresas' => $cantidadEmpresas,
         'cantidadDiagnosticos' => $cantidadDiagnosticos,
         'cantidadDetalle' => $cantidadDetalle,

       ]);
    }


    public function actionAdministracion() {
        $cantidadUsuarios = Usuario::find()->count();
        $cantidadAuditorias = Auditoria::find()->count();
        return $this->render('administracion', ['cantidadUsuarios' => $cantidadUsuarios, 'cantidadAuditorias' => $cantidadAuditorias]);
    }
    public function actionAuditorias() {
        $cantidadAuditorias = Auditoria::find()->count();
        $cantidadRegistrosesion = Registrosesion::find()->count();
        return $this->render('auditorias', ['cantidadAuditorias' => $cantidadAuditorias, 'cantidadRegistrosesion' => $cantidadRegistrosesion]);
    }
    public function actionPermisos() {
        $cantidadRoles = Rol::find()->count();
        $cantidadModulos = Modulo::find()->count();
        $cantidadAcciones = Accion::find()->count();
        $cantidadTipoAccesos = Tipoacceso::find()->count();

        return $this->render('permisos', ['cantidadRoles' => $cantidadRoles,
         'cantidadModulos' => $cantidadModulos, 'cantidadAcciones' => $cantidadAcciones ,'cantidadTipoAccesos'=>$cantidadTipoAccesos]);
    }

    public function actionConstruccion() {
        return $this->render('construccion');
    }
    public function actionAyuda() {
        return $this->render('ayuda');
    }
}
