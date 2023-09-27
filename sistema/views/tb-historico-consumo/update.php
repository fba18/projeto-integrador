<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TbHistoricoConsumo $model */

$this->title = Yii::t('app', 'Update Tb Historico Consumo: {name}', [
    'name' => $model->id_consumo,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tb Historico Consumos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_consumo, 'url' => ['view', 'id_consumo' => $model->id_consumo]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tb-historico-consumo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
