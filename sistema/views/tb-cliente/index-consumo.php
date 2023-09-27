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

$this->title = Yii::t('app', 'Consumo por Cliente');
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
                /*[
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, TbCliente $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'cpf_cnpj' => $model->cpf_cnpj]);
                    }
                ],*/
                [

                    'label' => 'Ações',
                    'format' => 'raw',
                    'attribute'=>'acoes',

                    // here comes the problem - instead of parent_region I need to have parent
                    'value' => function ($dataProvider) {
                        return Html::a('<i class="bi bi-pencil"></i> Tratar',  Url::to("/tb-cliente/consumo-historico?cpf_cnpj=".$dataProvider['cpf_cnpj'], true), ['class' => 'btn btn-danger btn-sm', 'role' => 'modal-remote','target'=>'_blank']);
                    }
                ],
            ],
        ]); ?>

    <?php Pjax::end(); ?>

</div>
