<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\detail\DetailView;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReunionfamiliarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reunion familiares';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div id="w0s" class="x_panel">
  <div class="x_title"><h2><i class="fa fa-table"></i> REUNIONES FAMILIARES </h2>
    <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i> Atrás', ['/solicitud'], ['class'=>'btn btn-danger grid-button']) ?></div>
</div>
</div>
<?= $this->render('/solicitud/_encabezado', [
    'model_solicitud' => $model_solicitud,
]) ?>
  </div>

<div class="reunionfamiliar-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
          'id'=>'crud-datatable',
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'pjax'=>true,
          //Para que no busque automaticamente, sino que espere a que se teclee ENTER
          'filterOnFocusOut'=>false,
          'columns' => require(__DIR__.'/_columns.php'),
          'toolbar'=> [
            ['content'=>
                Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create', 'id_solicitud'=>$model_solicitud->id],
                ['role'=>'modal-remote','title'=> 'Crear reunión','class'=>'btn btn-default']).
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index','id_solicitud'=>$model_solicitud->id],
                ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Refrescar'])
            ],
          ],
          'striped' => true,
          'condensed' => true,
          //Adaptacion para moviles
          'responsiveWrap' => false,
          'panel' => [
              'type' => 'primary',
              'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de reuniones familiares',
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
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'class' => 'bg-gray',
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
