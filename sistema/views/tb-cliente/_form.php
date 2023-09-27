<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\MaskedInput;

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
                                        <div class="col-lg-3 col-sm-12 col-xs-12 col-md-6">
                                            <?php //$form->field($model, 'cpf_cnpj')->textInput(['maxlength' => true]) ?>
                                            <?= $form->field($model, 'cpf_cnpj')->widget(MaskedInput::class, [
                                                'mask' => ['999.999.999-99', '99.999.999/9999-99'], // Define as máscaras para CPF e CNPJ
                                                'options' => ['maxlength' => true],
                                                'clientOptions' => [
                                                    'removeMaskOnSubmit' => true, // Remove a máscara antes de enviar o formulário
                                                ],
                                            ])->textInput(['maxlength' => true]) ?>
                                           <span id="cpf-cnpj-validation-message" style="color: red;"></span>

                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-xs-12 col-md-6">
                                        <?= $form->field($model, 'data_nascimento')->textInput(['type' => 'date']) ?>
                                        </div>
                                    </div>
                                    <div class="container-fluid w-auto row">
                                        <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-xs-12 col-md-6">
                                            <?php // $form->field($model, 'telefone')->textInput(['maxlength' => true]) ?>
                                            <?= $form->field($model, 'telefone')->widget(MaskedInput::class, [
                                                'mask' => ['(99) 9999-9999', '(99) 99999-9999'],
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
                                            <?php //$form->field($model, 'cep')->textInput(['maxlength' => true]) ?>
                                            <?= $form->field($model, 'cep')->widget(MaskedInput::class, [
                                                'mask' => '99999-999', // Máscara para CEP
                                                'options' => ['maxlength' => true],
                                                'clientOptions' => [
                                                    'removeMaskOnSubmit' => true,
                                                ],
                                            ])->textInput(['maxlength' => true]) ?>
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


<script>
        // Função para validar CPF
        /*function isValidCPF(cpf) {
            cpf = cpf.replace(/[^\d]+/g, ''); // Remove caracteres não numéricos

            if (cpf.length !== 11) return false;

            // Validação do CPF
            var sum = 0;
            var remainder;

            for (var i = 1; i <= 9; i++) {
                sum += parseInt(cpf.substring(i - 1, i)) * (11 - i);
            }

            remainder = (sum * 10) % 11;

            if ((remainder === 10) || (remainder === 11)) {
                remainder = 0;
            }

            if (remainder !== parseInt(cpf.substring(9, 10))) {
                return false;
            }

            sum = 0;

            for (var i = 1; i <= 10; i++) {
                sum += parseInt(cpf.substring(i - 1, i)) * (12 - i);
            }

            remainder = (sum * 10) % 11;

            if ((remainder === 10) || (remainder === 11)) {
                remainder = 0;
            }

            if (remainder !== parseInt(cpf.substring(10, 11))) {
                return false;
            }

            return true;
        }

        // Função para validar CNPJ
        function isValidCNPJ(cnpj) {
            cnpj = cnpj.replace(/[^\d]+/g, ''); // Remove caracteres não numéricos

            if (cnpj.length !== 14) return false;

            // Validação do CNPJ
            var size = cnpj.length - 2;
            var numbers = cnpj.substring(0, size);
            var digits = cnpj.substring(size);
            var sum = 0;
            var pos = size - 7;

            for (var i = size; i >= 1; i--) {
                sum += numbers.charAt(size - i) * pos--;

                if (pos < 2) {
                    pos = 9;
                }
            }

            var result = sum % 11 < 2 ? 0 : 11 - (sum % 11);

            if (result !== parseInt(digits.charAt(0))) {
                return false;
            }

            size = size + 1;
            numbers = cnpj.substring(0, size);
            sum = 0;
            pos = size - 7;

            for (var i = size; i >= 1; i--) {
                sum += numbers.charAt(size - i) * pos--;

                if (pos < 2) {
                    pos = 9;
                }
            }

            result = sum % 11 < 2 ? 0 : 11 - (sum % 11);

            if (result !== parseInt(digits.charAt(1))) {
                return false;
            }

            return true;
        }

        // Adicione um ouvinte de evento para verificar a validade quando o campo for preenchido
        document.getElementById('tbcliente-cpf_cnpj').addEventListener('blur', function () {
            var input = this;
            var value = input.value;
            var messageElement = document.getElementById('cpf-cnpj-validation-message');

            if (value.length === 14 && !isValidCNPJ(value)) {
                messageElement.textContent = 'CNPJ inválido';
                input.setAttribute('aria-invalid', 'true');
            } else if (value.length === 11 && !isValidCPF(value)) {
                messageElement.textContent = 'CPF inválido';
                input.setAttribute('aria-invalid', 'true');
            } else {
                messageElement.textContent = '';
                input.setAttribute('aria-invalid', 'false');
            }
        });

        // Adicione um ouvinte de evento para verificar a validade antes de enviar o formulário
        document.getElementById('myForm').addEventListener('submit', function (event) {
            var input = document.getElementById('tbcliente-cpf_cnpj');
            var value = input.value;

            if ((value.length === 14 && !isValidCNPJ(value)) || (value.length === 11 && !isValidCPF(value))) {
                var messageElement = document.getElementById('cpf-cnpj-validation-message');
                messageElement.textContent = 'CPF ou CNPJ inválido';
                input.setAttribute('aria-invalid', 'true');
                event.preventDefault(); // Impede o envio do formulário se CPF ou CNPJ for inválido
            }
        });*/
    </script>

    <script>
        // Adicione um ouvinte de evento para verificar a validade quando o campo perder o foco (blur)
        document.getElementById('tbcliente-cpf_cnpj').addEventListener('blur', function () {
            var input = this;
            var value = input.value;
            var messageElement = document.getElementById('cpf-cnpj-validation-message');

            // Use AJAX para chamar a validação do modelo no servidor
            $.ajax({
                type: 'POST',
                url: 'validate-cpf-cnpj', // Substitua pelo URL real da ação de validação no servidor
                data: {
                    'TbCliente[cpf_cnpj]': value
                },
                success: function (data) {
                    if (data.valid) {
                        messageElement.textContent = ''; // CPF ou CNPJ válido, limpe a mensagem de erro
                        input.setAttribute('aria-invalid', 'false');
                    } else {
                        messageElement.textContent = 'CPF ou CNPJ inválido'; // CPF ou CNPJ inválido, exiba a mensagem de erro
                        input.setAttribute('aria-invalid', 'true');
                    }
                }
            });
        });
    </script>