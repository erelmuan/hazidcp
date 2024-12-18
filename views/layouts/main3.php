
<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */
use \yii\web\View ;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;
use kartik\widgets\Growl;
use kartik\widgets\SwitchInput;
use yii\bootstrap\Nav;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FontAwesome;

AppAsset::register($this);
$bundle = yiister\gentelella\assets\Asset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta charset="<?= Yii::$app->charset ?>" />
  <link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/assets/fontawesome/css/all.min.css">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
   <?= Html::cssFile('@web/css/plantillas-intro.css') ?>
   <!-- efecto sobre los modulos  -->
   <?= Html::cssFile('@web/css/animate.min.css') ?>
   <?= Html::jsFile('@web/js/jquery.min.js') ?>
   <?= Html::jsFile('@web/js/sweetalert2.all.min.js') ?>
   <?= Html::jsFile('@web/js/flashjs/dist/flash.min.js') ?>
   <link href="<?= Yii::$app->request->baseUrl ?>/css/custom.<?=Yii::$app->user->identity->configuracion->tema->descripcion?>.css" rel="stylesheet" id="estilo-original">

   <?=$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/ico', 'href' => Url::base(true).'/favicon.ico']); ?>

   <style>
   .modal-content p {
       font-size: 80px !important; /* Ajusta el tamaño de fuente según las necesidades */
   }
   </style>

</head>
<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>" >

<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => FontAwesome::icon('fa fa-medkit') ." ".Yii::$app->name ." ".Yii::$app->params['version'],
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
     if (Yii::$app->user->identity->id_pantalla==1 && !User::isUserAdmin()){
       echo Nav::widget([
           'options' => ['class' => 'navbar-nav navbar-right'],

           'items' => [
             [   "label" => Yii::$app->user->identity->usuario,
               'options' => ['class' => 'btn-primary', ],
                 "icon" => "fa fa-files-o",
                 "url" => "#",
                 "items" => [
                     ["label" => FontAwesome::icon('glyphicon glyphicon-user') ." Perfil", "url" => ["/usuario/perfil"]],
                     ["label" => FontAwesome::icon('glyphicon glyphicon-cog') ." Configuración", "url" => ["/usuario/configuracion"]],
                     ["label" => FontAwesome::icon('glyphicon glyphicon-question-sign') ." Ayuda", "url" => ["/site/ayuda"]],
                 ],
             ],
               ["label" => "SALIR", "url" => "#", "icon" => "fa fa-file-text-o" ,'options' => ['class' => 'btn-danger'],'linkOptions' => [ 'onclick' => 'cerrarSesion()'] ],

           ]
           ,'encodeLabels' => false,
       ]);


     }else {

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ["label" => FontAwesome::icon('fa fa-home') ." Inicio", "url" => ["/site/index"]],
                [   "label" => FontAwesome::icon('fa fa-table') ." Tablas extras",
                    "url" => "#",
                    "items" => [
                        ["label" => "Procedencias", "url" => ["/procedencia/index"]],
                        ["label" => "Especialidades  ", "url" => ["/especialidad/index"]],
                        ["label" => "Tipos de actividad", "url" => ["/tipoactividad/index"]],
                        ["label" => "Respuestas", "url" => ["/respuesta/index"]],
                        ["label" => "Obras sociales", "url" => ["/obrasocial/index"]],
                        ["label" => "Estados", "url" => ["/estado/index"]],

                    ],
                ],

                ["label" =>FontAwesome::icon('fa fa-users') . " Pacientes", "url" => ["/paciente/index"]],
                ["label" =>FontAwesome::icon('fa fa-user') . " Prestadores", "url" => ["/prestador/index"]],
                ["label" =>FontAwesome::icon('fa fa-user-md') . " Profesionales", "url" => ["/profesional/index"]],
                ["label" => FontAwesome::icon('fa fa-file-text') ." Solicitudes", "url" => ["/solicitud/index"]],
                ["label" =>FontAwesome::icon('fa fa-comments') . " Actividades", "url" => ["/actividad/index"]],
                [   "label" => Yii::$app->user->identity->usuario,
                  'options' => ['class' => 'btn-primary', ],
                    "icon" => "fa fa-files-o",
                    "url" => "#",
                    "items" => [
                        ["label" => FontAwesome::icon('glyphicon glyphicon-user') ." Perfil", "url" => ["/usuario/perfil"]],
                        ["label" => FontAwesome::icon('glyphicon glyphicon-cog') ." Configuración", "url" => ["/usuario/configuracion"]],
                        ["label" => FontAwesome::icon('glyphicon glyphicon-question-sign') ." Ayuda", "url" => ["/site/ayuda"]],
                    ],
                ],

                ["label" => "SALIR", "url" => "#", "icon" => "fa fa-file-text-o" ,'options' => ['class' => 'btn-danger'],'linkOptions' => [ 'onclick' => 'cerrarSesion()'] ],

            ]
            ,'encodeLabels' => false,
        ]);

      }

    NavBar::end();
    // Obtener la instancia de la sesión
    $session = Yii::$app->session;
    // Iniciar la sesión si no está iniciada aún
    if (!$session->isActive) {
        $session->open();
    }

    if($session->get('mensajeDelSistema')=="bienvenido" ){  ?>
      <div id="loader-out">
        <div id="loader-container">
          <p id="loading-text">BIENVENIDO <?=Yii::$app->user->identity->usuario ?> </p>
        </div>
      </div>
      <?
      $session->set('mensajeDelSistema', 'adios');
      }
      ?>



    <div class="container">

        <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
                    <?php
                    echo \kartik\widgets\Growl::widget([
                        'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                        'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
                        'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                        'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
                        'showSeparator' => true,
                        'delay' => 0, //This delay is how long before the message shows
                        'pluginOptions' => [
                          'showProgressbar' => true,
                            'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
                            'placement' => [
                                'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                                'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                            ]
                        ]
                    ]);
                    ?>
                <?php endforeach; ?>

        <div class="clearfix"></div>
        <?= $content ?>
    </div>
</div>

<!-- footer content -->
<footer style="margin-left:auto">
    <div id="datosHospital">
        Hospital "Artémides ZATTI" - Rivadavia 391 - (8500) Viedma - Río Negro  (<?= date('Y') ?>)<br />
        Tel. 02920 - 427843 | Fax 02920 - 429916 / 423780
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->


<?php $this->endBody() ?>
<script>

$( document ).ready(function() {
  // Handler for .ready() called.
  setTimeout(function(){
    $('#loader-out').fadeOut();
  }, 1300);

  $(document).ajaxSuccess(function(event, xhr, settings) {
      // Verificar si `event` y `event.target` están definidos
      if (event && event.target && event.target.id !== 'crud-datatable-pjax') {
          // Verificar si `xhr.responseJSON` está definido y tiene la propiedad `metodo`
          if (xhr.responseJSON && (xhr.responseJSON.metodo === 'delete' || xhr.responseJSON.metodo === 'action' )) {
              location.reload();
          }
      }
  });

});
function cerrarSesion(){
  $.ajax({
      url: '<?php echo Url::to(['/site/logout']) ?>',
      type: 'post',
  });
}


</script>
</body>
</html>
<?php $this->endPage() ?>
