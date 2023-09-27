<?php

use app\models\TbCliente;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\TbClienteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Tb Clientes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-cliente-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tb Cliente'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'cpf_cnpj',
                'nome',
                'data_nascimento',
                'email:email',
                'telefone',
                //'cep',
                //'rua',
                //'numero',
                //'complemento',
                //'bairro',
                //'cidade',
                //'uf',
                //'tb_clientecol',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, TbCliente $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'cpf_cnpj' => $model->cpf_cnpj]);
                    }
                ],
            ],
        ]); ?>

    <?php Pjax::end(); ?>

</div>