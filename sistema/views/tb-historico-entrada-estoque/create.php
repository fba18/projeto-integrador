<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TbHistoricoEntradaEstoque $model */

$this->title = Yii::t('app', 'Create Tb Historico Entrada Estoque');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tb Historico Entrada Estoques'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-historico-entrada-estoque-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
