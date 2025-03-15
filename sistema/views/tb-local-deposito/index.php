<?php

use app\models\TbLocalDeposito;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\TbLocalDepositoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Tb Local Depositos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-local-deposito-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tb Local Deposito'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_local_deposito',
            'nome_deposito',
            'endereco_deposito',
            'uf',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TbLocalDeposito $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_local_deposito' => $model->id_local_deposito]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
