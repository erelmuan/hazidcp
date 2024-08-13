<?php

//use yii\widgets\DetailView;
use common\components\Modal;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Solicitud */
?>

<div class="profesional-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'apellido',
            'nombre',
            'tipodoc',
            'numdocumento',
            'matricula',
            [
              'class'=>'\kartik\grid\DataColumn',
              'label'=>'Especialidad',
              'value' => $model->especialidad->nombre ,
            ],
            [
              'class'=>'\kartik\grid\DataColumn',
              'label'=>'usuario',
              'value' => ( $model->usuario)?$model->usuario->usuario:'No definido' ,
            ],
           'visualizar:boolean',

        ],
    ]) ?>

</div>
