<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\grid\EditableColumn;
use yii\bootstrap\Collapse;
use yii\data\ActiveDataProvider;
//use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use kartik\editable\Editable;
use yii\widgets\DatePicker;
use app\models\TbCliente;
use app\models\TbProduto;
use app\models\TbEstoque;
use app\models\TbHistoricoConsumo;
use kartik\select2\Select2;

use yii\helpers\ArrayHelper;
use app\models\TbProdutoSearch;
use yii\widgets\MaskedInput;
use yii\bootstrap4\Modal;

$clienteModel = new TbCliente();
$produtoModel = new TbProduto();
$estoqueModel = new TbEstoque();
$historicoConsumoModel = new TbHistoricoConsumo();

$this->title = Yii::t('app', 'Inserir consumo para o cliente: '). $model->nome;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Voltar'), 'url' => 'javascript:history.go(-1)'];

/** @var yii\web\View $this */
/** @var app\models\TbHistoricoConsumo $model */
/** @var yii\widgets\ActiveForm $form */
?>
<div class="content">
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
    <div class="tb-historico-consumo-form">

        <?php $form = ActiveForm::begin(); ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    <i class="fas fa-edit"></i>
                                    <h4>&nbsp1 - Dados Cliente:</h4>
                                    </h3>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">
                                    <div class="container-fluid w-auto row">
                                        <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">

                                        <?= $form->field($model, 'cpf_cnpj')->widget(MaskedInput::class, [
                                                'mask' => ['999.999.999-99', '99.999.999/9999-99'], // Define as máscaras para CPF e CNPJ
                                                'options' => ['maxlength' => true],
                                                'clientOptions' => [
                                                    'removeMaskOnSubmit' => true, // Remove a máscara antes de enviar o formulário
                                                ],
                                            ])->textInput(['maxlength' => true, 'readonly' => true])->label('CPF / CNPJ') ?>

                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'nome')->textInput(['maxlength' => true,'readonly' => true])->label('Nome Cliente') ?>
                                        </div>
                                        <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($model, 'data_nascimento')->textInput(['type' => 'date', 'readonly' => true])->label('Data de Nascimento') ?>
                                        </div>
                                        <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'telefone')->widget(MaskedInput::class, [
                                                'mask' => ['(99) 9999-9999', '(99) 99999-9999'],
                                                'options' => ['maxlength' => true],
                                                'clientOptions' => [
                                                    'removeMaskOnSubmit' => true,
                                                ],
                                            ])->textInput(['maxlength' => true, 'readonly' => true])->label('Telefone / Celular') ?>
                                        </div>
                                    </div>
                                    <div class="container-fluid w-auto row">
                                        <div class="col-lg-4 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'readonly' => true])->label('E-mail') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    <i class="fas fa-edit"></i>
                                    <h4>&nbsp2 - Endereço Cliente:</h4>
                                    </h3>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">
                                    <div class="container-fluid w-auto row">
                                        <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'rua')->textInput(['maxlength' => true, 'readonly' => true])->label('Rua / Av') ?>
                                        </div>
                                        <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($model, 'numero')->textInput(['maxlength' => true, 'readonly' => true])->label('Número') ?>
                                        </div>

                                        <div class="col-lg-4 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($model, 'complemento')->textInput(['maxlength' => true, 'readonly' => true])->label('Complemento') ?>
                                        </div>
                                    </div>
                                    <div class="container-fluid w-auto row">
                                        <div class="col-lg-4 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($model, 'bairro')->textInput(['maxlength' => true, 'readonly' => true])->label('Bairro') ?>
                                        </div>
                                        <div class="col-lg-4 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($model, 'cidade')->textInput(['maxlength' => true, 'readonly' => true])->label('Cidade') ?>
                                        </div>
                                        <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($model, 'uf')->textInput(['maxlength' => true, 'readonly' => true])->label('UF') ?>
                                        </div>
                                        <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($model, 'cep')->widget(MaskedInput::class, [
                                                'mask' => '99999-999', // Máscara para CEP
                                                'options' => ['maxlength' => true],
                                                'clientOptions' => [
                                                    'removeMaskOnSubmit' => true,
                                                ],
                                            ])->textInput(['maxlength' => true, 'readonly' => true])->label('CEP') ?>
                                        </div>
                                    </div>
                                    <div class="container-fluid w-auto row">
                                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">
                                            <div class="form-group">
                                                <?php //Html::button('Inserir Consumo', ['value'=>Url::to('/tb-historico-consumo/historico?cpf_cnpj='.$model->cpf_cnpj), 'class' => 'btn btn-success','id'=>'modalButton']) ?>
                                                <?php //Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>







        <?php //$form->field($model, 'id_cliente_cpf_cnpj')->textInput() ?>



        <?php  //$form->field($model, 'id_consumo')->textInput() ?>

        <?php //$form->field($model, 'id_estoque')->textInput() ?>

        <?php //$form->field($model, 'id_num_produto')->textInput() ?>





        <?php ActiveForm::end(); ?>

    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-edit"></i>
                            <h4>&nbsp3 - Histórico Consumo:</h4>
                            </h3>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">
                            <div class="container-fluid w-auto row">
                                <?php //Pjax::begin(); ?>
                                    <div class="table-responsive col-lg-12 col-xs-12 col-sm-12 col-md-6 ">
                                        <!-- Grideview   -->


                                        <?= GridView::widget
                                            (
                                                [
                                                    'dataProvider' => $dataProvider,
                                                    //Filtro de pesquisa
                                                    //'filterModel' => $searchModel,
                                                    'pjax' => true,
                                                    'responsive'=>true,
                                                    'resizableColumns'=> false,
                                                    'responsiveWrap' => false,
                                                    'striped' => true,
                                                    'containerOptions'=>['style'=>'overflow: auto; font-size:1em;'],
                                                    'options' => ['class'=>'table table-condensed', 'style'=>''],
                                                    'resizableColumnsOptions' => [ 'resizeFromBody' => false],

                                                    //Botões de exportação e de expansão da quantidade de resultados da Grideview --v
                                                    'toolbar'=>
                                                    [
                                                        '{export}',
                                                        '{toggleData}',
                                                    ],

                                                    'hover'=>true,

                                                    'panel' =>
                                                    [
                                                        //Título do painel
                                                        'heading'=>'&nbsp',

                                                        'type'=>'primary',

                                                        //Parte acima do Pagination   (Rodapé)
                                                        'after'=>Html::button('Inserir Consumo', ['value'=>Url::to('/tb-historico-consumo/historico?cpf_cnpj='.$model->cpf_cnpj), 'class' => 'btn btn-success','id'=>'modalButton']),
                                                        //Parte acima do Pagination   (Rodapé)
                                                        'footer'=>'',

                                                    ],

                                                    //Colunas da Gridview
                                                    'columns' =>
                                                    [
                                                        //['class' => 'yii\grid\SerialColumn'],
                                                        //Itens comentados para não exibir na grideview

                                                        [
                                                            //Coluna da tabela no banco de dados
                                                            'attribute' => 'data_consumo',
                                                            'format' => ['date', 'php:d-m-Y'],
                                                            //Título para exibição da coluna
                                                            'header' => 'Data Consumo',
                                                            //Configuração/Estilo do título da coluna
                                                            'headerOptions' => [
                                                                'style' => 'text-align: center; width: 15%;'
                                                            ],
                                                            //Configuração/Estilo dos dados a serem exibidos na coluna
                                                            'contentOptions' => [
                                                                'style' => 'text-align: center;'

                                                            ]
                                                        ],
                                                        /*[
                                                            'attribute' => 'id_consumo',
                                                            'header' => 'ID',
                                                            'headerOptions' => [
                                                                'style' => 'text-align: center; width: 4%;'
                                                            ],
                                                            'contentOptions' => [
                                                                'style' => 'text-align: center;'
                                                            ]
                                                        ],*/
                                                        /*[
                                                            'attribute' => 'id_cliente_cpf_cnpj',
                                                            'header' => 'CPF/CNPJ',
                                                            'headerOptions' => [
                                                                'style' => 'text-align: center; width: 9%;'
                                                            ],
                                                            'contentOptions' => [
                                                                'style' => 'text-align: center;'
                                                            ]
                                                        ],*/
                                                        //'nome',
                                                        [
                                                            'attribute' => 'num_produto',
                                                            'header' => 'Cód. Produto',
                                                            'headerOptions' => [
                                                                'style' => 'text-align: center; width: 9%;'
                                                            ],
                                                            'contentOptions' => [
                                                                'style' => 'text-align: center;'
                                                            ]
                                                        ],
                                                        [
                                                            'attribute' => 'nome_produto',
                                                            'header' => 'Nome Produto',
                                                            //Configuração/Estilo do título da coluna
                                                            'headerOptions' => [
                                                                'style' => 'text-align: center; width: 15%;'
                                                            ],
                                                            //Configuração/Estilo dos dados a serem exibidos na coluna
                                                            'contentOptions' => [
                                                                'style' => 'text-align: center;'

                                                            ]
                                                        ],
                                                        [
                                                            'attribute' => 'estado_produto',
                                                            'header' => 'Estado Produto',
                                                            //Configuração/Estilo do título da coluna
                                                            'headerOptions' => [
                                                                'style' => 'text-align: center; width: 15%;'
                                                            ],
                                                            //Configuração/Estilo dos dados a serem exibidos na coluna
                                                            'contentOptions' => [
                                                                'style' => 'text-align: center;'

                                                            ]
                                                        ],
                                                        //'preco_produto',
                                                        [
                                                            'attribute' => 'preco_produto',
                                                            'header' => 'Preço Produto',
                                                            'format' => ['currency', 'BRL'], // Use 'BRL' para o Real brasileiro
                                                            'headerOptions' => [
                                                                'style' => 'text-align: center; width: 15%;'
                                                            ],
                                                            //Configuração/Estilo dos dados a serem exibidos na coluna
                                                            'contentOptions' => [
                                                                'style' => 'text-align: center;'

                                                            ]
                                                        ],
                                                        /*[
                                                            'attribute' => 'id_estoque',
                                                            'header' => 'Id Estoque',
                                                            'headerOptions' => [
                                                                'style' => 'text-align: center; width: 9%;'
                                                            ],
                                                            'contentOptions' => [
                                                                'style' => 'text-align: center;'
                                                            ]
                                                        ],*/
                                                        [
                                                            'attribute' => 'endereco_item',
                                                            'header' => 'Endereço Produto',
                                                            'headerOptions' => [
                                                                'style' => 'text-align: center; width: 15%;'
                                                            ],
                                                            //Configuração/Estilo dos dados a serem exibidos na coluna
                                                            'contentOptions' => [
                                                                'style' => 'text-align: center;'

                                                            ]
                                                        ],
                                                        /*[
                                                            'attribute' => 'qtd_itens',
                                                            'header' => 'Quantidade disponível',
                                                            'headerOptions' => [
                                                                'style' => 'text-align: center; width: 15%;'
                                                            ],
                                                            //Configuração/Estilo dos dados a serem exibidos na coluna
                                                            'contentOptions' => [
                                                                'style' => 'text-align: center;'

                                                            ]
                                                        ],*/

                                                        //'qtd_consumida',
                                                        [
                                                            'attribute' => 'qtd_consumida',
                                                            'header' => 'Qtd. Cosumida',
                                                            'headerOptions' => [
                                                                'style' => 'text-align: center; width: 9%;'
                                                            ],
                                                            'contentOptions' => [
                                                                'style' => 'text-align: center;'
                                                            ]
                                                        ],
                                                        /*[
                                                            'attribute' => 'user',
                                                            'header' => 'Usuário',
                                                            'headerOptions' => [
                                                                'style' => 'text-align: center; width: 15%;'
                                                            ],
                                                            'contentOptions' => [
                                                                'style' => 'text-align: center;'
                                                            ]
                                                        ],
                                                        [
                                                            'attribute' => 'obs',
                                                            'header' => 'Tratativa',
                                                            'headerOptions' => [
                                                                'style' => 'text-align: center;'
                                                            ],
                                                            'contentOptions' => [
                                                                'style' => 'text-align: left;'
                                                            ]
                                                        ],*/
                                                        //'id',
                                                        //'nr_chamado',
                                                        //'dt_criacao',
                                                        //'idDependencia',
                                                        //'codigoReferenciaOrigem',
                                                        //'user',
                                                        //'obs',

                                                        // ['class' => 'yii\grid\ActionColumn'],


                                                    ],
                                                ]
                                            );

                                        ?>


                                    </div>
                                <?php //Pjax::end(); ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!--Modal -->
    <?php
        Modal::begin(
            [
                'headerOptions' => ['class' => 'bg-primary'],
                'title' => '<h4>Inserir Consumo</h4>',
                'id' => 'modal',
                'size' => 'modal-lg',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
                'bodyOptions' => ['class' => 'modal-body', 'style' => 'padding:0px;'],
            ]
            );

            echo "<div id='modalContent' class=''></div>";

        Modal::end();
    ?>
