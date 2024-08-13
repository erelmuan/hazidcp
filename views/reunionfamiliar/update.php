<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Reunionfamiliar */
?>
<div class="reunionfamiliar-update">

    <?= $this->render('_form', [
        'model' => $model,
        'id_solicitud' => $id_solicitud,
        'search' => $search,
        'provider' => $provider,

    ]) ?>

</div>
