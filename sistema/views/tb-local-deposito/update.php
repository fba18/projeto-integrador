<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TbLocalDeposito $model */

$this->title = Yii::t('app', 'Update Tb Local Deposito: {name}', [
    'name' => $model->id_local_deposito,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tb Local Depositos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_local_deposito, 'url' => ['view', 'id_local_deposito' => $model->id_local_deposito]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tb-local-deposito-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
