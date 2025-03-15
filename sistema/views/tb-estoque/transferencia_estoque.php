<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\grid\EditableColumn;
use yii\bootstrap\Collapse;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use kartik\editable\Editable;
use yii\widgets\DatePicker;
use app\models\TbProduto;
use kartik\select2\Select2;

use yii\helpers\ArrayHelper;
use app\models\TbProdutoSearch;
use yii\widgets\MaskedInput;

//use yii;
//use yii\grid\GridView;
$produtoModel = new TbProduto();

$this->title = Yii::t('app', 'Saldo Estoque');

/** @var yii\web\View $this */
/** @var app\models\TbEstoque $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="content">
    <?php
    //var_dump($produtoModel);die;
    //$produtos=$produtoModel->getProdutos();
    //var_dump($produtos);

    //echo "<br><br>";
    //echo "este é o resultado: ";

    ?>

    <div class="tb-estoque-form">
        <?php $form = ActiveForm::begin(); ?>
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
                                        <?php
                                            /*<div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
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

                                            </div>*/
                                        ?>

                                    </div>
                                    <div class="container-fluid w-auto row">
                                        <div class="col-lg-3 col-sm-12 col-xs-12 col-md-6">
                                            <label>Você está no estoque de: </label>
                                            <?php
                                                $deposito = Yii::$app->db->createCommand("SELECT nome_deposito FROM tb_local_deposito WHERE id_local_deposito = $model->id_local_deposito ")->queryScalar();
                                            ?>
                                            <span class="form-control" readonly><?=$deposito?></span>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-xs-12 col-md-6">
                                            <?php
                                                $model->id_local_deposito = NULL;
                                            ?>
                                            <?= $form->field($model, 'id_local_deposito')->dropDownList(
                                                ArrayHelper::map($localDepositos, 'id_local_deposito', 'nome_deposito'),
                                                [
                                                    'prompt' => 'Selecione um depósito',
                                                    'onchange' => "
                                                        var id_local_deposito = $('#tbestoque-id_local_deposito').val(); // Pegando o valor do dropdown
                                                        var num_produto = $('#tbproduto-num_produto').val(); // Pegando o valor de num_produto do campo tbproduto-num_produto

                                                        if (id_local_deposito !== '') {
                                                            $.ajax({
                                                                url: 'obter-saldo-disponivel-transferencia', // Caminho da ação no controller
                                                                type: 'GET', // Tipo da requisição
                                                                data: {
                                                                    num_produto: num_produto,
                                                                    id_local_deposito: id_local_deposito
                                                                },
                                                                success: function(response) {
                                                                    var data = JSON.parse(response); // Parse do JSON recebido
                                                                    if (data.length > 0) {
                                                                        var saldo = data[0].qtd_itens; // Supondo que a resposta tenha a chave qtd_itens
                                                                        $('#saldo_disponivel').text(saldo); // Preenche o saldo disponível no span
                                                                    } else {
                                                                        $('#saldo_disponivel').text('0'); // Caso não haja dados
                                                                    }
                                                                },
                                                                error: function() {
                                                                    $('#saldo_disponivel').text('Erro ao obter saldo'); // Caso ocorra erro na requisição
                                                                }
                                                            });
                                                        } else {
                                                            $('#saldo_disponivel').text(''); // Se não houver depósito selecionado, limpa o saldo
                                                        }
                                                    "
                                                ]
                                            )->label('Transferir de:'); ?>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-xs-12 col-md-6">
                                            <label>Saldo Disponível para transferência: </label>
                                            <span id = "saldo_disponivel" class="form-control" readonly></span>
                                        </div>
                                        <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                            <?php
                                                $model->qtd_itens = 0;
                                            ?>
                                            <?= $form->field($model, 'qtd_itens')->textInput()->label('Qtd a transferir') ?>
                                        </div>
                                        <div class=" col-lg-1 col-sm-12 col-xs-12 col-md-6 ">
                                            <br>
                                            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Salvar') : Yii::t('app', '<i class="bi bi-truck"></i>&nbspTranferir'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary btn-sm']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php ActiveForm::end(); ?>

    </div>
</div>
