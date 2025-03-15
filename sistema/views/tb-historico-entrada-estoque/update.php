<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TbHistoricoEntradaEstoque $model */

$this->title = Yii::t('app', 'Update Tb Historico Entrada Estoque: {name}', [
    'name' => $model->id_historico_entrada_estoque,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tb Historico Entrada Estoques'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_historico_entrada_estoque, 'url' => ['view', 'id_historico_entrada_estoque' => $model->id_historico_entrada_estoque]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tb-historico-entrada-estoque-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
