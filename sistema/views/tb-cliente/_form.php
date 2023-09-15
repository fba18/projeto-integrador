<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

/** @var yii\web\View $this */
/** @var app\models\TbCliente $model */
/** @var yii\widgets\ActiveForm $form */

$js = <<<JS
    $('#tbcliente-cep').blur(function () {
        var cep = $(this).val();
        if (cep) {
            $.ajax({
                url: '/tb-cliente/obter-endereco-cep?cep=' + cep,
                method: 'GET',
                success: function (data) {
                    console.log(data);
                    if (!data.error) {
                        if (!data.erro){
                            $('#tbcliente-rua').val(data.logradouro);
                            $('#tbcliente-bairro').val(data.bairro);
                            $('#tbcliente-cidade').val(data.localidade);
                            $('#tbcliente-uf').val(data.uf);
                        }else{
                            alert('CEP não encontrado');
                            // Limpar os campos de endereço, se desejar
                            $('#tbcliente-rua').val('');
                            $('#tbcliente-bairro').val('');
                            $('#tbcliente-cidade').val('');
                            $('#tbcliente-uf').val('');
                        }
                    } else {

                    }
                },
                error: function () {
                    alert('Erro ao buscar o CEP');
                }
            });
        }
    });
JS;

$this->registerJs($js, View::POS_READY);

?>
<div class="content">
    <div class="tb-cliente-form">

        <?php $form = ActiveForm::begin(); ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    <i class="fas fa-edit"></i>
                                    <h4>&nbsp1 - Dados Pessoais:</h4>
                                    </h3>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">
                                    <div class="container-fluid w-auto row">
                                        <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'data_nascimento')->textInput() ?>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'cpf_cnpj')->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div>
                                    <div class="container-fluid w-auto row">
                                        <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'telefone')->textInput(['maxlength' => true]) ?>
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
                                    <h4>&nbsp2 - Endereço:</h4>
                                    </h3>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-6">
                                    <div class="container-fluid w-auto row">
                                        <div class="col-lg-2 col-sm-12 col-xs-12 col-md-6">
                                            <!-- Campo CEP para preenchimento automático -->
                                            <?= $form->field($model, 'cep')->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-lg-5 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'rua')->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-lg-1 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-lg-4 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'complemento')->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div>
                                    <div class="container-fluid w-auto row">
                                        <div class="col-lg-3 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'bairro')->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'cidade')->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-lg-1 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'uf')->textInput(['maxlength' => true]) ?>
                                        </div>
                                    </div>
                                    <div class="container-fluid w-auto row">
                                        <div class="form-group">
                                            <?= Html::submitButton(Yii::t('app', 'Salvar'), ['class' => 'btn btn-success']) ?>
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
