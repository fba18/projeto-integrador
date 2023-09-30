<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TbHistoricoConsumo $model */

$this->title = Yii::t('app', 'Inserir Consumo');
$this->params['breadcrumbs'][] = ['label' => 'Voltar', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tb Historico Consumos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-historico-consumo-create">

    <!--h1>< ?= Html::encode($this->title) ?></h1-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
