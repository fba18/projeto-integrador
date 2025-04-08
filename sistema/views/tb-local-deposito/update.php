<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TbLocalDeposito $model */

$this->title = Yii::t('app', 'Atualizar Local Deposito: {name} - {local}', [
    'name' => $model->id_local_deposito,
    'local' => $model->nome_deposito,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Locais Depósitos'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_local_deposito, 'url' => ['view', 'id_local_deposito' => $model->id_local_deposito]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Atualizar');
?>
<div class="tb-local-deposito-update">

    <!--h1><?= Html::encode($this->title) ?></h1-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
