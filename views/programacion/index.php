<?php
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\Quirofano;
use kartik\select2\Select2;
use kartik\grid\GridView;

use kartik\widgets\TimePicker;
use yii\widgets\MaskedInput;
Icon::map($this, Icon::WHHG);
use yii\bootstrap\Modal;
// Maps the Elusive icon font framework/* @var $this yii\web\View */

$this->title = 'Calendario';
?>
<!-- 1. jQuery UI -->
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.8.17/jquery-ui.min.js"></script>
<?//= Html::jsFile('@web/js/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') ?>


<style>
.tile-stats{
background: #E6FDBD;
}


</style>

  <?php
  use derekisbusy\panel\PanelWidget;

  ?>
  <div id="w022" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-calendar"></i> Calendario  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site'], ['class'=>'btn btn-danger grid-button']) ?></div>
    </div>
  </div>
  <div class="x_panel" >
      <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
      </ul>
      <legend class="text-info"><small>Buscar horarios disponibles</small></legend>
      <div class="x_content" style="display: none;">
        <div class="calendario-search">
          <div class="wiew-quirofanos-disponibles-index">
              <div id="ajaxCrudDatatable">
                  <?=GridView::widget([
                      'id'=>'crud-datatable',
                      'dataProvider' => $dataProvider,
                      'filterModel' => $searchModel,
                      'pjax'=>true,
                      'columns' => require(__DIR__.'/_columns.php'),
                      'toolbar'=> [
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                        ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Refrescar'])
                      ],
                      'striped' => true,
                      'condensed' => true,
                      //Adaptacion para moviles
                      'responsiveWrap' => false,
                      'panel' => [
                          'type' => 'primary',
                          'before'=>'<em>* Fecha Cirugia y Horario Inicio muestran resultados iguales y mayores al dato.</em>',

                      ]
                  ])?>
              </div>
          </div>



        </div>


      </div>
  </div>

  <div class="body-content">


  <div class="row">
    <div class="col-md-12">
<h4>Información de los colores</h4>
<p>
  <span class="badge badge-primary" style="background-color: #498e47; font-size: 16px;">Alta disponibilidad</span>
  <span class="badge badge-secondary" style="background-color: #aeb316; font-size: 16px;">Baja disponibilidad</span>
  <span class="badge badge-success"style="background-color: #d51d1d; font-size: 16px;">Sin disponibilidad</span>
  <span class="badge badge-danger"style="background-color: #114bf9;font-size: 16px;">Dias sin atención</span>
</p>
</div>

<?
  $this->title = Yii::t('app', 'Calendario');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= yii2fullcalendar\yii2fullcalendar::widget([
    'header' => [
      'left' => 'prev,next today',
      'center' => 'title',
      //'right' => 'picker month,agendaWeek,agendaDay',
      'right' => 'picker month',
  ],
      'options' => [
        'lang' => 'es',

        //... more options to be defined here!
        // 'defaultView'=> 'month',
      ],
       // 'events' => Url::to(['/paciente']),
      // 'ajaxEvents' => Url::to(['/paciente']),
      'events'=> $events,
      'clientOptions' => [
        'theme' => true,
        'themeSystem' => 'jquery-ui',
       // 'themeSystem' => 'bootstrap3',
        'weekends'=> true, //ocultará sábados y domingos
        'height'=> 1000,
        'width'=> 300,
          'selectable' => true,
         'eventLimit' => true,
         'dayClick'=>new JSExpression("function(date, allDay, jsEvent, view ) {
          window.location.href = 'index.php?r=cirugiaprogramada/fecha&dia='+ date.format();

        }"),
        'eventClick'=> new JSExpression("function(date, info, jsEvent ) {
          date.url;
        }"),
        'eventRender'=> new JSExpression("function(event, element) {
            element.css('font-size', '1.2em');
            element.css('padding', '0.5px');
        }"),


        // 'select' => new JSExpression("function(date, allDay, jsEvent, view ) {
        //   //console.log('hol');

        //   window.location.href = 'index.php?r=cirugiaprogramada/fecha&dia='+ date.format();

        //    // if (view.name == 'day')
        //    // return;
        //        // view.calendar.gotoDate(date);
        //        // view.calendar.changeView('agendaDay');
        // }"),
        // 'eventSources' => ['/eventcalendar/index'],
        // 'eventSources' => [
        //     $eventList,
        //     $icalList,
        // ],
    ],



    ]);
?>


</div>

</div>
</div>
