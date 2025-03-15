<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TbHistoricoEntradaEstoque $model */

$this->title = $model->id_historico_entrada_estoque;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tb Historico Entrada Estoques'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tb-historico-entrada-estoque-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id_historico_entrada_estoque' => $model->id_historico_entrada_estoque], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id_historico_entrada_estoque' => $model->id_historico_entrada_estoque], [
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
            'id_historico_entrada_estoque',
            'id_local_deposito',
            'id_estoque',
            'num_produto',
            'data_inclusao',
            'qtd_inclusao',
            'tipo_entrada',
            'id_local_deposito_anterior',
            'id_usuario_inclusao',
        ],
    ]) ?>

</div>
