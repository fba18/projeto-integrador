<?php

use app\models\TbEstoque;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;

use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use yii\bootstrap\Collapse;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;
use kartik\editable\Editable;
/** @var yii\web\View $this */
/** @var app\models\TbEstoqueSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Estoque';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tb-estoque-index">

    <div id="message" class='col-lg-12 alertflipper ' > <?php if (Yii::$app->session->hasFlash('error')): ?>
 		 <div class="alert alert-success alert-dismissable col-lg-4" style="position:absolute;top:180px;left:150px;z-index:1000000;">
  		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  		<h3><i class="icon fa fa-check"></i>Atenção!</h3>
  		<?= Yii::$app->session->getFlash('error') ?>
 		 </div>
	 <?php endif; ?>
    </div>

    <!--h1><?= Html::encode($this->title) ?></h1-->
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <!--?= Html::a('Create Tb Estoque', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?php Pjax::begin(); ?>

        <div class="table-responsive col-lg-12 col-xs-12 col-sm-12  " >

            <?= GridView::widget(
                [
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
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

                        'before'=>
                            Html::a('<i class="fa fa-sync fa-spin" style="animation-iteration-count: 1;animation-duration: 0.3s"></i> Limpar Filtros'
                            , ['index'], ['class' => 'btn btn-primary btn-sm']),


                        'footer'=>'',
                    ],
                    'columns' => [
                        //['class' => 'yii\grid\SerialColumn'],

                        //'id_estoque',
                        'num_produto',
                        'nome_produto' => [
                            'attribute' => 'nome_produto',
                            'enableSorting' => true,
                        ],
                        'qtd_itens',
                        'endereco_item',
                        'nome_deposito' => [
                            'label' => 'Local Depósito',
                            'attribute' => 'nome_deposito',
                            'enableSorting' => true,
                        ],

                        'estado_produto' => [
                            'attribute' => 'estado_produto',
                            'enableSorting' => true,
                        ],
                        /*'preco_produto' =>[
                            'attribute' => 'preco_produto',
                            'enableSorting' => true,
                        ],*/
                        'preco_produto' => [
                            'attribute' => 'preco_produto',
                            'enableSorting' => true,
                            'format' => ['raw'],
                            //'label' => 'Preço Produto',
                            'value' => function ($model) {
                               return \Yii::$app->formatter->asCurrency($model->preco_produto, 'BRL');
                            }
                         ],


                        /*[
                            'class' => ActionColumn::className(),
                            'urlCreator' => function ($action, TbEstoque $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id_estoque' => $model->id_estoque]);
                            }
                        ],*/
                        [

                            'label' => 'Editar',
                            'format' => 'raw',
                            'attribute'=>'acoes',

                            // here comes the problem - instead of parent_region I need to have parent
                            'value' => function ($dataProvider) {
                                return Html::a('<i class="bi bi-pencil"></i>',  Url::to("/tb-estoque/update?id_estoque=".$dataProvider['id_estoque'], true), ['class' => 'btn btn-outline-danger btn-sm', 'role' => 'modal-remote','target'=>'_blank']);
                            }
                        ],
                        [

                            'label' => 'Transferir',
                            'format' => 'raw',
                            'attribute'=>'acoes',

                            // here comes the problem - instead of parent_region I need to have parent
                            'value' => function ($dataProvider) {
                                return Html::a('<i class="bi bi-arrow-left-right"></i> <i class="bi bi-truck"></i>',  Url::to("/tb-estoque/transferir-estoque?id_estoque=".$dataProvider['id_estoque'], true), ['class' => 'btn btn-outline-primary btn-sm', 'role' => 'modal-remote','target'=>'_blank']);
                            }
                        ],
                    ],
                ]);
            ?>
        </div>

    <?php Pjax::end(); ?>

</div>
