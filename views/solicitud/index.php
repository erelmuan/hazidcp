<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use yii\bootstrap\Collapse;
use kartik\widgets\AlertBlock;
$this->title = 'Solicitudes';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
// Reemplazo la columna donde el valor es getlink por la funcion anonima, este artilugio es necesario


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
    'filename' => 'Solicitudes', // Aquí especifica el nombre de archivo personalizado
]);


$columns[]=
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action,'id'=>$key]);
        },
        'template'=> '{reunion}{evolucion}{view}{update}{delete}',
        'buttons'=>[
          'evolucion' => function ($url, $model, $key) {
            return Html::a(
              "<button class='btn-info btn-circle'><b>E</b></button>", ['evolucionindicacion/index', 'id_solicitud' => $model->id], ['data-pjax'=>"0",'title'=>"Evoluciones"]) ;
            },
          'reunion' => function ($url, $model, $key) {
            return Html::a(
              "<button class='btn-warning btn-circle'><b>R</b></button>", ['/reunionfamiliar', 'id_solicitud'=> $model->id,'id_carnet' => null], ['data-pjax'=>"0",'title'=>"Reunión fliar"]) ;
            },
        ],
        'updateOptions'=>['title'=>'Actualizar', 'data-toggle'=>'tooltip','icon'=>"<button class='btn-primary btn-circle'><span class='glyphicon glyphicon-pencil'></span></button>"],
        'options' => ['style' => 'width:7%'],

        'visibleButtons'=>[
            'view'=> ['view'],
            'update'=> ['update'],
            'delete'=> ['delete']
            ]
    ];


?>
<div id="w0s" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> SOLICITUDES  </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/site'], ['class'=>'btn btn-danger grid-button']) ?></div>
</div>
  </div>
<p>

    <?= Html::a('Nueva solicitud', Yii::$app->homeUrl."paciente/pacienteregistro", ['class' => 'btn btn-success']) ?>

</p>
<?=$export; ?>
<div class="solicitud-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            //Para que no busque automaticamente, sino que espere a que se teclee ENTER
            //'filterOnFocusOut'=>false,
            'columns' => $columns,
            'toolbar'=> [
              ['content'=>
                  Html::a('<i class="glyphicon glyphicon-bed"></i>', ['configusuariopac/pacienteselect','modelo' => 'app\models\Configusuariopac'],
                  ['role'=>'modal-remote','title'=> 'Personalizar','class'=>'btn btn-default']).
                  Html::a('<i class="glyphicon glyphicon-th"></i>', ['vista/select','modelo' => 'app\models\Solicitud'],
                  ['role'=>'modal-remote','title'=> 'Personalizar','class'=>'btn btn-default']).
                  Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                  ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Refrescar'])
              ]
            ],
            'striped' => true,
            'condensed' => true,
            //Adaptacion para moviles
            'responsiveWrap' => false,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de solicitudes',
                'before'=>'<em>* Para buscar algún registro tipear en el filtro y presionar ENTER </em>',

                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    'size' => Modal::SIZE_LARGE,
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
