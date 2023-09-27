<?php

use app\models\TbHistoricoConsumo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\TbHistoricoConsumoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Tb Historico Consumos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-historico-consumo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tb Historico Consumo'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_consumo',
            'id_estoque',
            'id_num_produto',
            'id_cliente_cpf_cnpj',
            'qtd_consumida',
            //'data_consumo',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TbHistoricoConsumo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_consumo' => $model->id_consumo]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
