<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TbLocalDeposito $model */

$this->title = $model->id_local_deposito;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tb Local Depositos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tb-local-deposito-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id_local_deposito' => $model->id_local_deposito], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id_local_deposito' => $model->id_local_deposito], [
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
            'id_local_deposito',
            'nome_deposito',
            'endereco_deposito',
            'uf',
        ],
    ]) ?>

</div>
