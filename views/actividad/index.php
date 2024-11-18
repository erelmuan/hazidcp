
<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\bootstrap\Collapse;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActividadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Actividades';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

$export = ExportMenu::widget([
    'exportConfig' => [
        ExportMenu::FORMAT_TEXT => false,
        ExportMenu::FORMAT_HTML => false,
        ExportMenu::FORMAT_PDF => [
            'icon' => 'fa fa-file-pdf-o',
        ],
        ExportMenu::FORMAT_CSV => [
            'icon' => 'fa fa-file-text-o',
        ],
        ExportMenu::FORMAT_TEXT => [
            'icon' => 'fa fa-file-text',
        ],
        ExportMenu::FORMAT_EXCEL => [
            'icon' => 'fa fa-file-excel-o',
        ],
        ExportMenu::FORMAT_EXCEL_X => [
            'icon' => 'fa fa-file-excel-o',
        ],
    ],
    'dataProvider' => $dataProvider,
    'columns' => require(__DIR__ . '/_columns.php'),
    'dropdownOptions' => [
        'label' => 'Todo',
        'class' => 'btn btn-secondary',
        'itemsBefore' => [
            '<div class="dropdown-header">Exportar Todos los Datos</div>',
        ],
    ],
    'filename' => 'Actividades', // Aquí especifica el nombre de archivo personalizado
]);

?>
<div class="col-xs-12 col-sm-6 col-md-4">
    <?php
    echo Collapse::widget([
        'items' => [
            [
                'label' => 'Buscar por rango de fecha',
                'content' => $this->render('_search', ['model' => $searchModel]),
            ],
        ],
    ]);
    ?>
</div>
<div  class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> ACTIVIDADES  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site'], ['class'=>'btn btn-danger grid-button']) ?></div>
</div>
  </div>
  <?=$export; ?>

<div class="Actividad-index">
  <div id="ajaxCrudDatatable">
      <?=GridView::widget([
          'id'=>'crud-datatable',
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'pjax'=>true,
          'columns' => require(__DIR__.'/_columns.php'),
          'toolbar'=> [
              ['content'=>
                  Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                  ['role'=>'modal-remote','title'=> 'Crear nueva actividad','class'=>'btn btn-default']).
                  Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                  ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Refrescar'])
              ],
          ],
          'striped' => true,
          'condensed' => true,
          //Adaptacion para moviles
          'responsiveWrap' => false,
          'panel' => [
              'type' => 'primary',
              'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de activiades',
              'before'=>'<em>* Para buscar algún registro tipear en el filtro y presionar ENTER o el boton <i class="glyphicon glyphicon-search"></i></em>',

                      '<div class="clearfix"></div>',
          ]
      ])?>
  </div>
</div>
</div>

<?php


Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],

])?>
<?php Modal::end(); ?>
<?php
$this->registerJs("
    $('#ajaxCrudModal').off('shown.bs.modal').on('shown.bs.modal', function () {
        $('#pacienteint-autocomplete').autocomplete({
            source: '" . Url::to(['actividad/autocomplete']) . "',
            minLength: 4
        });
    });
", \yii\web\View::POS_READY);
?>
