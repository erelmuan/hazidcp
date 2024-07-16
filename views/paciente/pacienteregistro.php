<? use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\widgets\ActiveForm;
use kartik\form\ActiveField;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use app\models\Usuario;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RegistroatencionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Registro de atención';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="x_title">
  <h2>  <i class='glyphicon glyphicon-plus'></i> CARGAR REGISTRO </h2>


    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?=Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
</div>
  </div>

    <div class='row'>
      <div class="x_panel" >
        <legend class="text-info"><small>BUSQUEDA DEL PACIENTE</small></legend>
        <div class="x_content" style="display: block;">
          <div class="paciente-index">
              <div id="ajaxCrudDatatable">
                <?=GridView::widget([
                    'id'=>'crud-datatable',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    //Para que no busque automaticamente, sino que espere a que se teclee ENTER
                    'filterOnFocusOut'=>false,
                    'pjax'=>true,
                    'columns' => require(__DIR__.'/_columnsPaciente.php'),
                    'toolbar'=> [
                        ['content'=>
                            Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                            ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Refrescar']).
                            Html::a('<i class="glyphicon glyphicon-plus"></i> Nuevo', ['/paciente/create'], [
                                 'class'=>'btn btn-primary',
                                 'data-toggle'=>'tooltip',
                                 'title'=>'Crear paciente'
                             ])
                        ],
                    ],
                    //Adaptacion para moviles
                    'responsiveWrap' => false,
                    'panel' => [
                        'type' => 'primary',
                        'heading'=> 'Ingresar datos al filtro y presionar la tecla ENTER',
                    ]
                ])?>
              </div>
          </div>

         </div>
          </div>
          </div>

    </div>
   </div>


<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
