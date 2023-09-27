<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TbHistoricoConsumo $model */

$this->title = $model->id_consumo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tb Historico Consumos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tb-historico-consumo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id_consumo' => $model->id_consumo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id_consumo' => $model->id_consumo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_consumo',
            'id_estoque',
            'id_num_produto',
            'id_cliente_cpf_cnpj',
            'qtd_consumida',
            'data_consumo',
        ],
    ]) ?>

</div>
