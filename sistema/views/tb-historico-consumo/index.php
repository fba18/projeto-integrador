<?php

use app\models\TbHistoricoConsumo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
//use yii\grid\GridView;

use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use yii\bootstrap\Collapse;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;
use kartik\editable\Editable;
use yii\widgets\MaskedInput;

/** @var yii\web\View $this */
/** @var app\models\TbClienteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Histórico Consumo Geral');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-cliente-index">

    <!--h1<>?= Html::encode($this->title) ?></h1-->
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <!--p>
        < ?= Html::a(Yii::t('app', 'Create Tb Cliente'), ['tb-historico-consumo/create'], ['class' => 'btn btn-success']) ?>
    </p-->

    <?php Pjax::begin(); ?>
        <div class="table-responsive col-lg-12 col-xs-12 col-sm-12  " >

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'responsive'=>true,
                'resizableColumns'=>false,
                'responsiveWrap' => false,
                'striped'=>true,
                'containerOptions'=>['style'=>'overflow: auto; font-size:1.0em;',],
                'options' =>['class'=>'table table-condensed' ,'style'=>'font-size:1.0em'],
                'toolbar'=>[
                    '{export}',
                    '{toggleData}'
                ],
                'hover'=>true,
                'panel' => [

                    'heading'=>'&nbsp',

                    'type'=>'primary',

                    /*'before'=>
                        Html::a('<i class="fa fa-sync fa-spin" style="animation-iteration-count: 1;animation-duration: 0.3s"></i> Limpar Filtros'
                        , ['tb-cliente/index-consumo'], ['class' => 'btn btn-primary btn-sm']),*/


                    'footer'=>'',
                ],
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],

                    'id_consumo',
                    //'cpf_cnpj',
                    [
                        'attribute' => 'cpf_cnpj',
                        'label' => 'CPF / CNPJ',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $cpf_cnpj = $model['cpf_cnpj']; // Acesse a coluna 'cpf_cnpj' diretamente no array associativo
                            return MaskedInput::widget([
                                'name' => 'cpf_cnpj',
                                'value' => $cpf_cnpj,
                                'mask' => ['999.999.999-99', '99.999.999/9999-99'], // Máscaras para CPF e CNPJ
                                'options' => [
                                    'readonly' => true, // Torna o campo apenas de leitura
                                    'style' => 'border: none; background: none;', // Remove a aparência de input
                                ],
                            ]);
                        },
                    ],
                    'nome',
                    //'num_produto',
                    [
                        'attribute' => 'num_produto',
                        'label' => 'Cód. Produto',
                    ],
                    'nome_produto',
                    'estado_produto',
                    //'preco_produto',
                    [
                        'attribute' => 'preco_produto',
                        'label' => 'Preço Produto',
                    ],
                    //'id_estoque',

                    //'qtd_itens',
                    /*[
                        'attribute' => 'qtd_itens',
                        'label' => 'Qtd. Disponível',
                    ],*/
                    //'endereco_item',
                    [
                        'attribute' => 'endereco_item',
                        'label' => 'Endereço Item',
                    ],
                    //'qtd_consumida',
                    [
                        'attribute' => 'qtd_consumida',
                        'label' => 'Qtd. Consumida',
                    ],
                    //'data_consumo',
                    [
                        'attribute' => 'data_consumo',
                        'label' => 'Data Consumo',
                        'format' => ['date', 'php:d/m/Y']
                    ],


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
        </div>

    <?php Pjax::end(); ?>

</div>
