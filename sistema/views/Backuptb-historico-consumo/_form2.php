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
use kartik\select2\Select2;

use yii\helpers\ArrayHelper;
use app\models\TbProdutoSearch;
use yii\widgets\MaskedInput;
use yii\bootstrap4\Modal;

$clienteModel = new TbCliente();
$produtoModel = new TbProduto();
$estoqueModel = new TbEstoque();


/** @var yii\web\View $this */
/** @var app\models\TbHistoricoConsumo $model */
/** @var yii\widgets\ActiveForm $form */
?>
<div class="content">
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

                                        <?= $form->field($clienteModel, 'cpf_cnpj')->widget(Select2::classname(), [
                                                'data' => TbCliente::getCliente(),
                                                'options' => ['placeholder' => 'Selecione CPF ou CNPJ', 'id' => 'cpf_cnpj_select2'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                                'pluginEvents' => [
                                                    "change" => "function() {
                                                        if ($(this).val().length > 3) {
                                                            $.post('/tb-historico-consumo/obter-dados-cliente?cpf_cnpj=' + $(this).val(), function(data) {
                                                                var vl = JSON.parse(data);
                                                                $('input#tbcliente-nome').val(vl[1]);
                                                                $('input#tbcliente-data_nascimento').val(vl[2]);
                                                                $('input#tbcliente-telefone').val(vl[3]);
                                                                $('input#tbcliente-email').val(vl[4]);
                                                                $('input#tbcliente-rua').val(vl[5]);
                                                                $('input#tbcliente-numero').val(vl[6]);
                                                                $('input#tbcliente-complemento').val(vl[7]);
                                                                $('input#tbcliente-bairro').val(vl[8]);
                                                                $('input#tbcliente-cidade').val(vl[9]);
                                                                $('input#tbcliente-uf').val(vl[10]);
                                                                $('input#tbcliente-cep').val(vl[11]);

                                                                /*$('input#preco_produto').val('R$ ' + Number(vl[3]).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                                                                $('input#num_produto_estoque').val(vl[0]);*/

                                                                /*//Para vincular o código do produto à ID Estoque
                                                                var num_produto_estoque = $('#num_produto_estoque').val();
                                                                var id_estoque = $('#id_estoque');

                                                                id_estoque.val(num_produto_estoque);*/

                                                            });
                                                        } else {
                                                            alert('Erro');
                                                        }
                                                    }",
                                                ],
                                            ]);
                                            ?>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($clienteModel, 'nome')->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($clienteModel, 'data_nascimento')->textInput(['type' => 'date']) ?>
                                        </div>
                                        <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($clienteModel, 'telefone')->widget(MaskedInput::class, [
                                                'mask' => ['(99) 9999-9999', '(99) 99999-9999'],
                                                'options' => ['maxlength' => true],
                                                'clientOptions' => [
                                                    'removeMaskOnSubmit' => true,
                                                ],
                                            ])->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div>
                                    <div class="container-fluid w-auto row">
                                        <div class="col-lg-4 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($clienteModel, 'email')->textInput(['maxlength' => true]) ?>
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
                                            <?= $form->field($clienteModel, 'rua')->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($clienteModel, 'numero')->textInput(['maxlength' => true]) ?>
                                        </div>

                                        <div class="col-lg-4 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($clienteModel, 'complemento')->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div>
                                    <div class="container-fluid w-auto row">
                                        <div class="col-lg-4 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($clienteModel, 'bairro')->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-lg-4 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($clienteModel, 'cidade')->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($clienteModel, 'uf')->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($clienteModel, 'cep')->widget(MaskedInput::class, [
                                                'mask' => '99999-999', // Máscara para CEP
                                                'options' => ['maxlength' => true],
                                                'clientOptions' => [
                                                    'removeMaskOnSubmit' => true,
                                                ],
                                            ])->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <?= Html::button('Inserir Consumo',
                [
                    'class' => 'btn btn-primary bi bi-save',
                    'style' => 'font-size:20px;',
                    'id' => 'modalButton',
                    'data-toggle' => 'modal', // Adicione isso para abrir um modal
                    'data-target' => '#myModal', // Substitua 'myModal' pelo ID do seu modal
                ])
            ?>


        <?php //$form->field($model, 'id_cliente_cpf_cnpj')->textInput() ?>



        <?php  //$form->field($model, 'id_consumo')->textInput() ?>

        <?php //$form->field($model, 'id_estoque')->textInput() ?>

        <?php //$form->field($model, 'id_num_produto')->textInput() ?>



        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success openContentModal']) ?>
        </div>

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

                                <div class="table-responsive col-lg-12 col-xs-12 col-sm-12 col-md-6 ">
                                    <!-- Grideview   -->


                                    <?php //GridView::widget
                                        (
                                            [
                                                //'dataProvider' => $provider7,
                                                //Filtro de pesquisa
                                                //'filterModel' => $searchModel,
                                                'pjax' => true,
                                                'responsive'=>true,

                                                'responsiveWrap' => false,
                                                'containerOptions'=>['style'=>'overflow: auto; font-size:1em;'],

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
                                                    'after'=>Html::a('
                                                        <div >
                                                            <span >
                                                                <button type="button" class="glyphicon glyphicon-pencil btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTrat">
                                                                    <span style="font-family: Helvetica Neue, Helvetica, Arial, sans-serif">
                                                                        &nbspAdicionar Tratativa
                                                                    </span>
                                                                </button>
                                                            </span>
                                                        </div>'
                                                ),
                                                    //Parte acima do Pagination   (Rodapé)
                                                    'footer'=>'',

                                                ],

                                                //Colunas da Gridview
                                                'columns' =>
                                                [
                                                    //['class' => 'yii\grid\SerialColumn'],
                                                    //Itens comentados para não exibir na grideview
                                                    /*[
                                                        'attribute' => 'id',
                                                        'header' => 'ID',
                                                        'headerOptions' => [
                                                            'style' => 'text-align: center; width: 4%;'
                                                        ],
                                                        'contentOptions' => [
                                                            'style' => 'text-align: center;'
                                                        ]
                                                    ],
                                                    [
                                                        'attribute' => 'nr_chamado',
                                                        'header' => 'Chamado',
                                                        'headerOptions' => [
                                                            'style' => 'text-align: center; width: 9%;'
                                                        ],
                                                        'contentOptions' => [
                                                            'style' => 'text-align: center;'
                                                        ]
                                                    ],*/
                                                    [
                                                        //Coluna da tabela no banco de dados
                                                        'attribute' => 'dt_criacao',
                                                        //Título para exibição da coluna
                                                        'header' => 'Data / Hora',
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
                                                    ],
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



            //echo "<div id='modalContent' class=''></div>";

            ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    <i class="fas fa-edit"></i>
                                    <h4>&nbsp1 - Produto:</h4>
                                    </h3>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">
                                    <div class="container-fluid w-auto row">
                                        <?php
                                            $id = Yii::$app->request->get('id_estoque');
                                            if($id !== null) {
                                                //Apenas Update(Atualização)
                                                $produtoModel->num_produto = $xb->num_produto;
                                                $produtoModel->nome_produto = $xb->nome_produto;
                                                $produtoModel->estado_produto = $xb->estado_produto;
                                                $produtoModel->preco_produto = $xb->preco_produto;
                                                //var_dump($xb->num_produto)
                                                ?>
                                                <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                                    <?= $form->field($produtoModel, 'num_produto')->textInput(['readonly'=> true, 'maxlength' => true])->label('Código Produto') ?>
                                                    <?php //echo $numProduto;
                                                    //var_dump(TbProduto::getProdutos()); die; ?>
                                                </div>
                                                <div class="col-lg-4 col-sm-12 col-xs-12 col-md-6">
                                                    <?= $form->field($produtoModel, 'nome_produto')->textInput(['readonly'=> true, 'maxlength' => true, 'id' => 'nome_produto', ])->label('Nome Produto') ?>
                                                </div>
                                                <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                                    <?= $form->field($produtoModel, 'estado_produto')->textInput(['readonly'=> true, 'maxlength' => true, 'id' => 'estado_produto'])->label('Estado Produto') ?>
                                                </div>
                                                <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                                    <?php //$form->field($produtoModel, 'preco_produto')->textInput(['readonly'=> true, 'id' => 'preco_produto'])->label('Preço Produto') ?>

                                                    <?= $form->field($produtoModel, 'preco_produto')->widget(MaskedInput::className(), [
                                                        'clientOptions' => [
                                                            'alias' => 'currency',
                                                            'prefix' => 'R$ ',
                                                            'digits' => 2,
                                                            'digitsOptional' => false,
                                                            'radixPoint' => ',',
                                                            'groupSeparator' => '.',
                                                            'autoGroup' => true,
                                                            'removeMaskOnSubmit' => true,
                                                        ],
                                                        'options' => ['style'=> ' ', 'class'=> 'input form-control ','readonly' => true, // Adiciona a opção para deixar somente leitura
                                                        ]
                                                    ])->label('Preço Produto') ?>
                                                    <style>
                                                        input[name="TbProduto[preco_produto]"].form-control {
                                                            text-align: left;
                                                        }
                                                    </style>
                                                <?php



                                            } else {
                                                //Apenas Create(Novo item)
                                                ?>
                                                <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                                    <?= $form->field($produtoModel, 'num_produto')->widget(Select2::classname(), [
                                                        'data' => TbProduto::getProdutos(),
                                                        'options' => ['placeholder' => 'Selecione um produto', 'id' => 'num_produto_select2'],
                                                        'pluginOptions' => [
                                                            'allowClear' => true,
                                                        ],
                                                        'pluginEvents' => [
                                                            "change" => "function() {
                                                                if ($(this).val().length > 3) {
                                                                    $.post('/tb-estoque/obter-dados-saldo-estoque?num_produto=' + $(this).val(), function(data) {
                                                                        var vl = JSON.parse(data);
                                                                        $('input#nome_produto').val(vl[1]);
                                                                        $('input#estado_produto').val(vl[2]);

                                                                        $('input#preco_produto').val('R$ ' + Number(vl[3]).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                                                                        $('input#num_produto_estoque').val(vl[0]);
                                                                        $('input#tbestoque-qtd_itens').val(vl[4]);
                                                                        $('input#tbestoque-endereco_item').val(vl[5]);





                                                                        //Para vincular o código do produto à ID Estoque
                                                                        var num_produto_estoque = $('#num_produto_estoque').val();
                                                                        var id_estoque = $('#id_estoque');

                                                                        id_estoque.val(num_produto_estoque);

                                                                    });
                                                                } else {
                                                                    alert('Erro');
                                                                }
                                                            }",
                                                        ],
                                                    ]);



                                                    ?>
                                                    <?php //echo $numProduto;
                                                    //var_dump(TbProduto::getProdutos()); die; ?>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                                                    <?= $form->field($produtoModel, 'nome_produto')->textInput(['readonly'=> true, 'maxlength' => true, 'id' => 'nome_produto', ])->label('Nome Produto') ?>
                                                </div>
                                                <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                                    <?= $form->field($produtoModel, 'estado_produto')->textInput(['readonly'=> true, 'maxlength' => true, 'id' => 'estado_produto'])->label('Estado Produto') ?>
                                                </div>
                                                <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                                    <?= $form->field($produtoModel, 'preco_produto')->textInput(['readonly'=> true, 'id' => 'preco_produto'])->label('Preço Produto') ?>
                                                    <?php /*$form->field($model, 'preco_produto')->widget(MaskedInput::className(), [
                                                        'clientOptions' => [
                                                            'alias' => 'currency',
                                                            'prefix' => 'R$ ',
                                                            'digits' => 2,
                                                            'digitsOptional' => false,
                                                            'radixPoint' => ',',
                                                            'groupSeparator' => '.',
                                                            'autoGroup' => true,
                                                            'removeMaskOnSubmit' => true,
                                                        ],
                                                        'options' => ['style'=> ' ', 'class'=> 'input form-control ','readonly' => true, ]
                                                    ])->label('Preço Produto') */ ?>
                                                    <!--style>
                                                        input[name="TbProduto[preco_produto]"].form-control {
                                                            text-align: left;
                                                        }
                                                    </style-->
                                                </div>
                                            <?php

                                            }
                                        ?>
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
                                    <h4>&nbsp2 - Saldo Estoque:  </h4>
                                    </h3>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">
                                    <div class="container-fluid w-auto row">
                                        <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($estoqueModel, 'qtd_itens')->textInput(['readonly'=> true])->label('Qtd Itens') ?>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($estoqueModel, 'endereco_item')->textInput(['readonly'=> true, 'maxlength' => true])->label('Endereço Item') ?>
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
                                    <h4>&nbsp3 - Inserir consumo:  </h4>
                                    </h3>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">
                                    <div class="container-fluid w-auto row">
                                        <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'qtd_consumida')->textInput() ?>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'data_consumo')->textInput(['type' => 'date']) ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <div class="modal-footer justify-content-between">
                <div class="col-lg-4 ">
                    <button type="submit" class="btn btn-primary btn-block btn-sm"> Inserir</button>
                </div>
                <div class="col-lg-4 ">
                    <button type="button" class="btn btn-danger btn-block btn-sm" data-dismiss="modal"> Sair</button>
                </div>

            </div>


            <?php
        Modal::end();
    ?>
