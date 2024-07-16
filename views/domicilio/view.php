<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Domicilio */
?>
<div class="domicilio-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'direccion',
            'barrio.nombre',
            'paciente.apellido',
            [
              'value'=> $model->paciente->nombre.' '.$model->paciente->apellido,
              'label'=> 'Paciente',
           ],
            'provincia.nombre',
            'localidad.nombre',
            'id_tipodom',
            'fechabaja',
        ],
    ]) ?>

</div>
