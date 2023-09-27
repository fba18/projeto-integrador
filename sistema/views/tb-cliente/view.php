<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TbCliente $model */

$this->title = $model->cpf_cnpj;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tb Clientes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tb-cliente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'cpf_cnpj' => $model->cpf_cnpj], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'cpf_cnpj' => $model->cpf_cnpj], [
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
            'cpf_cnpj',
            'nome',
            'data_nascimento',
            'email:email',
            'telefone',
            'cep',
            'rua',
            'numero',
            'complemento',
            'bairro',
            'cidade',
            'uf',
            'tb_clientecol',
        ],
    ]) ?>

</div>
