<?php

use app\models\TbHistoricoEntradaEstoque;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\TbHistoricoEntradaEstoqueSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Tb Historico Entrada Estoques');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-historico-entrada-estoque-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tb Historico Entrada Estoque'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_historico_entrada_estoque',
            'id_local_deposito',
            'id_estoque',
            'num_produto',
            'data_inclusao',
            //'qtd_inclusao',
            //'tipo_entrada',
            //'id_local_deposito_anterior',
            //'id_usuario_inclusao',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TbHistoricoEntradaEstoque $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_historico_entrada_estoque' => $model->id_historico_entrada_estoque]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
