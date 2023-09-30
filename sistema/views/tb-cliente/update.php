<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TbCliente $model */

$this->title = Yii::t('app', 'Atualizar cliente: {name}', [
    'name' => $model->nome,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tb Clientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cpf_cnpj, 'url' => ['view', 'cpf_cnpj' => $model->cpf_cnpj]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tb-cliente-update">

    <!--h1>< ?= Html::encode($this->title) ?></h1-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
