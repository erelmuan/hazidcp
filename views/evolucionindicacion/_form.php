<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\detail\DetailView;
use yii\widgets\MaskedInput;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Evolucionindicacion */
/* @var $form yii\widgets\ActiveForm */
CrudAsset::register($this);

?>
<style>
.x_contentF {
    margin-left: 20px; /* Ajusta el valor según sea necesario */
}

</style>
<div class="x_panel">
    <div class="x_title">
        <h2> <?=$model->isNewRecord ? "<i class='glyphicon glyphicon-plus'></i> NUEVA EVOLUCIÓN" : "<i class='glyphicon glyphicon-pencil'></i> ACTUALIZAR EVOLUCIÓN" ; ?>
        </h2>
        <div class="clearfix">
            <div class="nav navbar-right panel_toolbox">
              <div class="clearfix"> <div class="nav navbar-right panel_toolbox"><?echo Html::button('<i class="glyphicon glyphicon-arrow-left"></i> Atrás',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','id'=>'botonAtras')); ?></div>
            </div>
        </div>
    </div>
</div>
<?= $this->render('/solicitud/_encabezado', [
    'model_solicitud' => $model_solicitud,
]) ?>

<div  role="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-sm-10 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Formulario de Evolución e Indicación</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_contentF">
                        <div class="evolucionindicacion-form">
                              <?php $form = ActiveForm::begin(); ?>
                              <div class="col-md-1 col-sm-8 col-xs-8 form-group">
                              <b>  Fecha y hora </b>
                              </div>
                              <div class="col-md-11 col-sm-12 col-xs-12 form-group">
                                <div class='col-sm-3'>
                                  <?= $form->field($model, 'fechahora')->widget(DateControl::classname(), [
                                      'type' => DateControl::FORMAT_DATETIME,
                                      'displayFormat' => 'dd/MM/yyyy HH:mm:ss',
                                      'saveFormat' => 'php:Y-m-d H:i:s',
                                      'options' => [
                                          'pluginOptions' => [
                                              'autoclose' => true,
                                          ],
                                      ],
                                  ])->label(false); ?>
                              </div>
                              </div>
                              <div class="col-md-1 col-sm-8 col-xs-8 form-group">
                              <b>  Tipo de registro </b>
                              </div>
                              <div class="col-md-11 col-sm-12 col-xs-12 form-group">
                                <div class='col-sm-3'>
                                  <?php echo $form->field($model, 'tiporegistro')->dropDownList([ 'indicacion' => 'Indicacion', 'evolucion' => 'Evolucion', ], ['prompt' => ''])->label(false);?>
                                </div>
                              </div>
                              <div class="col-md-1 col-sm-8 col-xs-8 form-group">
                              <b>  Observación </b>
                              </div>
                              <div class="col-md-11 col-sm-12 col-xs-12 form-group">
                                <div class='col-sm-8'>
                                  <?= $form->field($model, 'observacion')->textarea(['rows' => 6 , 'style'=> 'font-size:17px;'])->label(false);  ?>
                                </div>
                              </div>
                              <div class="col-md-1 col-sm-8 col-xs-8 form-group">
                              <b>  Usuario </b>
                              </div>
                              <div class="col-md-11 col-sm-12 col-xs-12 form-group">
                                <div class='col-sm-5'>
                                <?= $form->field($model, 'usuario')->textInput(['value'=> Yii::$app->user->identity->usuario, 'readonly'=>true])->label(false); ?>
                              </div>
                              </div>
                              <div class="col-md-1 col-sm-8 col-xs-8 form-group">
                              <b>  Especialidad </b>
                              </div>
                              <div class="col-md-11 col-sm-12 col-xs-12 form-group">
                                <div class='col-sm-5'>
                                 <?=$form->field($model, 'especialidad')->dropDownList(Yii::$app->user->identity->especialidadesArray)->label(false);?>
                              </div>
                              </div>

                                <?= $form->field($model, 'id_usuario')->hiddenInput(['value'=> Yii::$app->user->identity->id])->label(false) ;?>
                                <?= $form->field($model, 'enfermeria')->hiddenInput(['value' => 0])->label(false) ?>
                                <?= $form->field($model, 'id_internacion')->hiddenInput(['value' => $id_internacion])->label(false) ?>
                                <?= $form->field($model, 'nombreusuario')->hiddenInput(['value' => Yii::$app->user->identity->usuario])->label(false) ?>

                              <div class="col-md-8 col-sm-12 col-xs-12 form-group">
                          	<?php if (!Yii::$app->request->isAjax){ ?>
                          	  	<div class="form-group">
                          	        <?= Html::submitButton($model->isNewRecord ? 'Confirmar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                    <?=  Html::button(' Cancelar',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','class'=>'btn btn-danger')); ?>

                                </div>
                          	<?php } ?>
                            </div>
                              <?php ActiveForm::end(); ?>
                        </div>
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
