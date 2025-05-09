<?php

use app\models\TbHistoricoEntradaEstoque;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use kartik\export\ExportMenu;
use kartik\editable\Editable;
/** @var yii\web\View $this */
/** @var app\models\TbHistoricoEntradaEstoqueSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Histórico Entrada Estoques');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-historico-entrada-estoque-index">
    <div id="message" class='col-lg-12 alertflipper '>
        <?php if (Yii::$app->session->hasFlash('error')) : ?>
        <div class="alert alert-danger alert-dismissible col-lg-4" style="position:absolute;top:200px;left:150px;z-index:1000000;">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h3>
            <i class="icon fas fa-exclamation-triangle"></i>Atenção!
            </h3>
            <?= Yii::$app->session->getFlash('error') ?>
        </div>

        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('success')) : ?>
        <div class="alert alert-success alert-dismissible col-lg-4" style="position:absolute;top:200px;left:150px;z-index:1000000;">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h3>
            <i class="icon fas fa-exclamation-triangle"></i>Atenção!
            </h3>
            <?= Yii::$app->session->getFlash('success') ?>
        </div>

        <?php endif; ?>

    </div>

    <!--h1>< ?= Html::encode($this->title) ?></h1-->

    <p>
        <?php //Html::a(Yii::t('app', 'Create Tb Historico Entrada Estoque'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="table-responsive col-lg-12 col-xs-12 col-sm-12  " >
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'responsive'=>true,
                'resizableColumns'=>false,
                'responsiveWrap' => false,
                'striped'=>true,
                'containerOptions'=>['style'=>'overflow: auto; font-size:1.0em;',],
                'options' =>['class'=>'table' ,'style'=>'font-size:1.0em'],
                'toolbar'=>[
                    '{export}',
                    '{toggleData}'
                ],
                'exportContainer' => ['class' => 'btn-group-sm'],
                'toggleDataContainer' => ['class' => 'btn-group-sm'],
                'hover'=>true,
                'pager' => [
                    'firstPageLabel' => '<i class="fas fa-angle-double-left"></i>',
                    'lastPageLabel' => '<i class="fas fa-angle-double-right"></i>',
                    'options' => ['class' => 'pagination justify-content-center'],
                    'linkOptions' => ['class' => 'page-link'],
                    'disabledPageCssClass' => 'disabled',
                    'activePageCssClass' => 'active',
                ],
                'panel' => [

                    'heading'=>'&nbsp',

                    'type'=>'primary',

                    'before'=>
                        Html::a(Yii::t('app', 'Enviar Relário situação Estoque'), ['tb-estoque/enviar-relatorio-estoque'], ['class' => 'btn btn-outline-success btn-sm']).' '.
                        Html::a('<i class="fa fa-sync fa-spin" style="animation-iteration-count: 1;animation-duration: 0.3s"></i> Limpar Filtros'
                        , ['index'], ['class' => 'btn btn-outline-primary btn-sm']),


                    'footer'=>'',
                ],
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],

                    'id_historico_entrada_estoque' => [
                        'label' => 'Id Entrada Estoque',
                        'attribute' => 'id_historico_entrada_estoque',
                        'enableSorting' => true,
                    ],
                    'id_local_deposito' => [
                        'label' => 'Cód. Depósito',
                        'attribute' => 'id_local_deposito',
                        'enableSorting' => true,
                    ],
                    [

                        'label' => 'Depósito',
                        'format' => 'raw',
                        'attribute'=>'nome_deposit',

                        // here comes the problem - instead of parent_region I need to have parent
                        'value' => function ($dataProvider) {
                            $nome_deposito = (new \yii\db\Query())
                            ->select(['nome_deposito'])
                            ->from('tb_local_deposito')
                            ->where([
                                'id_local_deposito' => $dataProvider->id_local_deposito
                            ])
                            ->scalar();

                            return $nome_deposito;
                        }
                    ],
                    'id_estoque' => [
                        'label' => 'Id Estoque',
                        'attribute' => 'id_estoque',
                        'enableSorting' => true,
                    ],
                    'num_produto' => [
                        'label' => 'Cód. Produto',
                        'attribute' => 'num_produto',
                        'enableSorting' => true,
                    ],
                    [

                        'label' => 'Produto',
                        'format' => 'raw',
                        'attribute'=>'nome_deposit',

                        // here comes the problem - instead of parent_region I need to have parent
                        'value' => function ($dataProvider) {
                            $nome_produto = (new \yii\db\Query())
                            ->select(['nome_produto'])
                            ->from('tb_produto')
                            ->where([
                                'num_produto' => $dataProvider->num_produto
                            ])
                            ->scalar();

                            return $nome_produto;
                        }
                    ],
                    'data_inclusao' => [
                        'label' => 'Data Inclusão',
                        'attribute' => 'data_inclusao',
                        'enableSorting' => true,
                        'value' => function ($model) {
                        return Yii::$app->formatter->asDate($model->data_inclusao, 'php:d-m-Y');
                        },
                    ],
                    'qtd_inclusao' => [
                        'label' => 'Qtd Inclusão',
                        'attribute' => 'qtd_inclusao',
                        'enableSorting' => true,
                    ],
                    'tipo_entrada' => [
                        'label' => 'Tipo Entrada',
                        'attribute' => 'tipo_entrada',
                        'enableSorting' => true,
                    ],
                    [

                        'label' => 'Depósito Anterior',
                        'format' => 'raw',
                        'attribute'=>'nome_deposit',

                        // here comes the problem - instead of parent_region I need to have parent
                        'value' => function ($dataProvider) {
                            $nome_deposito_anterior = (new \yii\db\Query())
                            ->select(['nome_deposito'])
                            ->from('tb_local_deposito')
                            ->where([
                                'id_local_deposito' => $dataProvider->id_local_deposito_anterior
                            ])
                            ->scalar();

                            $nome_deposito_atual = (new \yii\db\Query())
                            ->select(['nome_deposito'])
                            ->from('tb_local_deposito')
                            ->where([
                                'id_local_deposito' => $dataProvider->id_local_deposito
                            ])
                            ->scalar();

                            if($dataProvider->id_local_deposito_anterior === 0){
                                return 'Inicial';
                            }elseif($nome_deposito_atual === $nome_deposito_anterior){
                                return 'Sem movimentação';
                            }else{
                                return 'teste';

                            }
                        }
                    ],
                    //'id_usuario_inclusao',
                    /*[
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, TbHistoricoEntradaEstoque $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id_historico_entrada_estoque' => $model->id_historico_entrada_estoque]);
                        }
                    ],*/
                ],
            ]); ?>
        </div>

    <?php Pjax::end(); ?>

</div>
